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
            SELECT m.marca_vehiculo AS marca, mo.modelo_vehiculo AS modelo, COUNT(vv.id_vehiculo) AS total_vendidos
            FROM vehiculos v
            JOIN venta_vehiculo vv ON v.id = vv.id_vehiculo
            JOIN marca_vehiculos m ON v.id_marca = m.id
            JOIN modelo_vehiculos mo ON v.id_modelo = mo.id
            GROUP BY v.id_marca, v.id_modelo
            ORDER BY total_vendidos DESC;
        ");

        $vendedoresMasVentas = DB::select("
            SELECT e.nombre, e.apellido, COUNT(f.id) AS total_ventas
            FROM facturas f
            JOIN empleados e ON f.id_empleado = e.id
            GROUP BY f.id_empleado
            ORDER BY total_ventas DESC;
        ");

        return view('partials.reportes-index', compact('masVendidos', 'vendedoresMasVentas'));
    }

    public function entradas()
    {
        $entradas = DB::select("
            SELECT v.id, mv.marca_vehiculo as marca, modv.modelo_vehiculo as modelo, v.año_modelo, v.tipo_vehiculo, cm.fecha_compra AS fecha_entrada
            FROM vehiculos v
            JOIN compra_vehiculo cv ON v.id = cv.id_vehiculo
            JOIN compras cm ON cv.id_compra = cm.id
            JOIN marca_vehiculos mv ON v.id_marca = mv.id
            JOIN modelo_vehiculos modv ON v.id_modelo = modv.id;
        ");
        $total_entradas = count($entradas);
        // Generate PDF
        $pdf = $this->generatePDF('reportes.entradas', compact('entradas', 'total_entradas'));
        return $pdf->stream('Vehiculos_Entradas.pdf');
    }

    public function salidas()
    {
        $salidas = DB::select("
            SELECT v.id, mv.marca_vehiculo as marca, modv.modelo_vehiculo as modelo, v.año_modelo, v.tipo_vehiculo, f.fecha AS fecha_salida
            FROM vehiculos v
            JOIN venta_vehiculo vv ON v.id = vv.id_vehiculo
            JOIN facturas f ON vv.id_factura = f.id
            JOIN marca_vehiculos mv ON v.id_marca = mv.id
            JOIN modelo_vehiculos modv ON v.id_modelo = modv.id
            WHERE vv.id_vehiculo IS NOT NULL;
        ");
        $total_salidas = count($salidas);
        // Generate PDF
        $pdf = $this->generatePDF('reportes.salidas', compact('salidas', 'total_salidas'));
        return $pdf->stream('Vehiculos_Salidas.pdf');
    }

    public function masVendidos()
    {
        $masVendidos = DB::select("
            SELECT mv.marca_vehiculo as marca, modv.modelo_vehiculo as modelo, COUNT(vv.id_vehiculo) AS total_vendidos
            FROM vehiculos v
            JOIN venta_vehiculo vv ON v.id = vv.id_vehiculo
            JOIN marca_vehiculos mv ON v.id_marca = mv.id
            JOIN modelo_vehiculos modv ON v.id_modelo = modv.id
            GROUP BY v.id
            ORDER BY total_vendidos DESC;
        ");
        $total_vendidos = count($masVendidos);
        // Generate PDF
        $pdf = $this->generatePDF('reportes.mas_vendidos', compact('masVendidos', 'total_vendidos'));
        return $pdf->stream('vehiculos_mas_vendidos.pdf');
    }

    public function menosVendidos()
    {
        $menosVendidos = DB::select("
            SELECT mv.marca_vehiculo as marca, modv.modelo_vehiculo as modelo, COUNT(vv.id_vehiculo) AS total_vendidos
            FROM vehiculos v
            JOIN venta_vehiculo vv ON v.id = vv.id_vehiculo
            JOIN marca_vehiculos mv ON v.id_marca = mv.id
            JOIN modelo_vehiculos modv ON v.id_modelo = modv.id
            GROUP BY v.id
            ORDER BY total_vendidos ASC;
        ");
        $total_vendidos = count($menosVendidos);
        // Generate PDF
        $pdf = $this->generatePDF('reportes.menos_vendidos', compact('menosVendidos', 'total_vendidos'));
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
