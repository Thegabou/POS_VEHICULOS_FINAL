<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReporteVehiculosController extends Controller
{
    public function index()
    {
        $masVendidos = DB::select("
            SELECT v.marca, v.modelo, COUNT(vv.id_vehiculo) AS total_vendidos
            FROM vehiculos v
            JOIN venta_vehiculo vv ON v.id = vv.id_vehiculo
            GROUP BY v.id
            ORDER BY total_vendidos DESC;
        ");

        $menosVendidos = DB::select("
            SELECT v.marca, v.modelo, COUNT(vv.id_vehiculo) AS total_vendidos
            FROM vehiculos v
            JOIN venta_vehiculo vv ON v.id = vv.id_vehiculo
            GROUP BY v.id
            ORDER BY total_vendidos ASC;
        ");

        return view('partials.reportes-index', compact('masVendidos', 'menosVendidos'));
    }

    public function entradas()
    {
        $entradas = DB::select("
            SELECT v.id, v.marca, v.modelo, v.año_modelo, v.tipo_vehiculo, cm.fecha_compra AS fecha_entrada
            FROM vehiculos v
            JOIN compra_vehiculo cv ON v.id = cv.id_vehiculo
            JOIN compras cm ON cv.id_compra = cm.id;
        ");
        $total_entradas = count($entradas);
        // Generate PDF
        $pdf = $this->generatePDF('reportes.entradas', compact('entradas', 'total_entradas'));
        return $pdf->stream('Vehiculos_Entradas.pdf');
    }

    public function salidas()
    {
        $salidas = DB::select("
            SELECT v.id, v.marca, v.modelo, v.año_modelo, v.tipo_vehiculo, f.fecha AS fecha_salida
            FROM vehiculos v
            JOIN venta_vehiculo vv ON v.id = vv.id_vehiculo
            JOIN facturas f ON vv.id_factura = f.id
            WHERE vv.id_vehiculo IS NOT NULL;
        ");
        $total_salidas = count($salidas);
        // Generate PDF
        $pdf = $this->generatePDF('reportes.salidas', compact('salidas' , 'total_salidas'));
        return $pdf->stream('Vehiculos_Salidas.pdf');
    }

    public function masVendidos()
    {
        $masVendidos = DB::select("
            SELECT v.marca, v.modelo, COUNT(vv.id_vehiculo) AS total_vendidos
            FROM vehiculos v
            JOIN venta_vehiculo vv ON v.id = vv.id_vehiculo
            GROUP BY v.id
            ORDER BY total_vendidos DESC;
        ");
        $total_vendidos = count($masVendidos);
        // Generate PDF
        $pdf = $this->generatePDF('reportes.mas_vendidos', compact('masVendidos' , 'total_vendidos'));
        return $pdf->stream('vehiculos_mas_vendidos.pdf');
    }

    public function menosVendidos()
    {
        $menosVendidos = DB::select("
            SELECT v.marca, v.modelo, COUNT(vv.id_vehiculo) AS total_vendidos
            FROM vehiculos v
            JOIN venta_vehiculo vv ON v.id = vv.id_vehiculo
            GROUP BY v.id
            ORDER BY total_vendidos ASC;
        ");
        $total_vendidos = count($menosVendidos);
        // Generate PDF
        $pdf = $this->generatePDF('reportes.menos_vendidos', compact('menosVendidos' , 'total_vendidos'));
        return $pdf->stream('vehiculos_menos_vendidos.pdf');
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
