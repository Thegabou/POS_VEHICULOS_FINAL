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
        $ventas = DB::table('facturas')
            ->whereDate('fecha', $date)
            ->get();
        $total_ventas = count($ventas);

        $pdf = $this->generatePDF('reportes.ventas-diarias', compact('ventas', 'total_ventas'));
        return $pdf->stream('Ventas_Diarias.pdf');
    }

    public function ventasSemanales(Request $request)
    {
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
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
