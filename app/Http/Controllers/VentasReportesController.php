<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;

class VentasReportesController extends Controller
{
    public function ventasDiarias(Request $request)
    {
        $date = $request->query('date');
        echo $date;
        if (!$date) {
            return response()->json(['error' => 'Fecha no proporcionada'], 400);
        }

        $ventas = DB::table('facturas as f')
            ->join('clientes as c', 'f.id_cliente', '=', 'c.id')
            ->join('venta_vehiculo as vv', 'f.id', '=', 'vv.id_factura')
            ->join('vehiculos as v', 'vv.id_vehiculo', '=', 'v.id')
            ->join('marca_vehiculos as mv', 'v.id_marca', '=', 'mv.id')
            ->join('modelo_vehiculos as modv', 'v.id_modelo', '=', 'modv.id')
            ->select(
                'f.numero_factura',
                'f.fecha',
                'c.cedula as cedula_cliente',
                'c.nombre as nombre_cliente',
                'c.apellido as apellido_cliente',
                'v.placa as vehiculo_placa',
                'mv.marca_vehiculo',
                'modv.modelo_vehiculo',
                'v.precio_venta',
                'f.total as total_venta'
            )
            ->whereDate('f.fecha', $date)
            ->get();

        $total_ventas = count($ventas);

        $pdf = $this->generatePDF('reportes.ventas-diarias', compact('ventas', 'total_ventas'));
        return $pdf->stream('Ventas_Diarias.pdf');
    }

    public function ventasSemanales(Request $request)
    {
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
        if (!$start_date || !$end_date) {
            return response()->json(['error' => 'Fechas no proporcionadas'], 400);
        }

        $ventas = DB::table('facturas')
            ->whereBetween('fecha', [$start_date, $end_date])
            ->get();
        $total_ventas = count($ventas);

        $pdf = $this->generatePDF('reportes.ventas-semanales', compact('ventas', 'total_ventas'));
        return $pdf->stream('Ventas_Semanales.pdf');
    }

    public function ventasMensuales(Request $request)
    {
        $month = $request->query('month');
        if (!$month) {
            return response()->json(['error' => 'Mes no proporcionado'], 400);
        }

        $ventas = DB::table('facturas')
            ->whereMonth('fecha', $month)
            ->get();
        $total_ventas = count($ventas);

        $pdf = $this->generatePDF('reportes.ventas-mensuales', compact('ventas', 'total_ventas'));
        return $pdf->stream('Ventas_Mensuales.pdf');
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

