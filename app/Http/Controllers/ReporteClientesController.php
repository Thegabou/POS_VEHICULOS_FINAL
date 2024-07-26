<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;
use ZipArchive;

class ReporteClientesController extends Controller
{
    public function historialCompras($clienteId)
    {
        $historial = DB::select("
            SELECT c.nombre, c.apellido, c.cedula, f.id AS factura_id, f.fecha AS fecha_compra, v.marca, v.modelo, v.año_modelo, v.tipo_vehiculo
            FROM clientes c
            JOIN facturas f ON c.id = f.id_cliente
            JOIN venta_vehiculo vv ON f.id = vv.id_factura
            JOIN vehiculos v ON vv.id_vehiculo = v.id
            WHERE c.id = ?
            ORDER BY f.fecha DESC
        ", [$clienteId]);
        // Generar PDF
        $pdf = $this->generatePDF('reportes.historial_compras', compact('historial'));

        // Descargar PDF
        return $pdf->stream('historial_compras.pdf');
    }

    public function generarReportes($clienteId)
    {
        $cliente = DB::table('clientes')->where('id', $clienteId)->first();

        $reportes = [
            'PC' => DB::select("
                SELECT c.nombre, c.apellido, c.cedula, v.marca, v.modelo, v.numero_chasis, v.numero_motor, COUNT(vv.id_vehiculo) AS veces_comprado
                FROM clientes c
                JOIN facturas f ON c.id = f.id_cliente
                JOIN venta_vehiculo vv ON f.id = vv.id_factura
                JOIN vehiculos v ON vv.id_vehiculo = v.id
                WHERE c.id = ?
                GROUP BY c.nombre, c.apellido, c.cedula, v.marca, v.modelo, v.numero_chasis, v.numero_motor
                ORDER BY veces_comprado DESC
            ", [$clienteId]),

            'FC' => DB::select("
                SELECT c.nombre, c.apellido, c.cedula, COUNT(f.id) AS total_compras
                FROM clientes c
                JOIN facturas f ON c.id = f.id_cliente
                WHERE c.id = ?
                GROUP BY c.nombre, c.apellido, c.cedula
                ORDER BY total_compras DESC
            ", [$clienteId]),

            'MPG' => DB::select("
                SELECT c.nombre, c.apellido, c.cedula, AVG(f.total) AS promedio_gastado
                FROM clientes c
                JOIN facturas f ON c.id = f.id_cliente
                WHERE c.id = ?
                GROUP BY c.nombre, c.apellido, c.cedula
                ORDER BY promedio_gastado DESC
            ", [$clienteId]),

            'CRC' => DB::select("
                SELECT c.nombre, c.apellido, c.cedula, COUNT(f.id) AS total_compras
                FROM clientes c
                JOIN facturas f ON c.id = f.id_cliente
                WHERE c.id = ?
                AND f.fecha >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
                GROUP BY c.nombre, c.apellido, c.cedula
                HAVING total_compras > 1
                ORDER BY total_compras DESC
            ", [$clienteId]),
        ];

        $zip = new ZipArchive;
        $zipFileName = 'reportes_' . $cliente->cedula . '.zip';
        $zipPath = public_path($zipFileName);

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($reportes as $acronimo => $reporte) {
                $pdf = $this->generatePDF('reportes.' . strtolower($acronimo), compact('reporte'));
                $pdfFilePath = public_path($cliente->cedula . '_' . $cliente->nombre . '_' . $cliente->apellido . '_' . $acronimo . '.pdf');
                file_put_contents($pdfFilePath, $pdf->output());
                $zip->addFile($pdfFilePath, basename($pdfFilePath));
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    private function generatePDF($view, $data)
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $html = view($view, $data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf;
    }
}
