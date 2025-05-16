<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Trade, User};
use Carbon\Carbon;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $tipo = $request->input('tipo', 'dia'); // por defecto: hoy
        $query = Trade::query();

        if ($tipo === 'dia') {
            $fechaInicio = Carbon::today()->startOfDay();
            $fechaFin = Carbon::today()->endOfDay();
            $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        } elseif ($tipo === 'mes') {
            $fechaInicio = Carbon::now()->startOfMonth();
            $fechaFin = Carbon::now()->endOfMonth();
            $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        } else { // 'anio'
            $fechaInicio = Carbon::now()->startOfYear();
            $fechaFin = Carbon::now()->endOfYear();
            $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }

        $total = $query->count();
        $ganados = (clone $query)->where('ganado', true)->count();
        $perdidos = (clone $query)->where('ganado', false)->count();
        $efectividad = $total > 0 ? round(($ganados / $total) * 100, 2) : 0;

        $ganancia = (clone $query)->where('ganado', true)->sum('pago');
        $perdida = (clone $query)->where('ganado', false)->sum('monto');
        $gananciaNeta = $ganancia - $perdida;

        // Datos para gráficos (ejemplos simples):

        // 1. Ganados vs Perdidos (Pie)
        $chartEfectividadData = [$ganados, $perdidos];

        // 2. Ganancia acumulada por fecha
        // Para simplificar, vamos a obtener ganancia neta diaria o mensual según filtro
        $gananciasPorFecha = [];
        $labelsGanancias = [];

        if ($tipo === 'dia') {
            // Mostrar ganancias por horas del día (0 a 23)
            for ($hora = 0; $hora < 24; $hora++) {
                $start = (clone $fechaInicio)->setHour($hora)->setMinute(0)->setSecond(0);
                $end = (clone $start)->setMinute(59)->setSecond(59);

                $gananciasHora = Trade::whereBetween('fecha', [$start, $end])
                    ->where('ganado', true)
                    ->sum('pago') -
                    Trade::whereBetween('fecha', [$start, $end])
                    ->where('ganado', false)
                    ->sum('monto');

                $labelsGanancias[] = $hora . ':00';
                $gananciasPorFecha[] = round($gananciasHora, 2);
            }
        } elseif ($tipo === 'mes') {
            $diasDelMes = $fechaInicio->daysInMonth;
            for ($dia = 1; $dia <= $diasDelMes; $dia++) {
                $start = (clone $fechaInicio)->setDay($dia)->startOfDay();
                $end = (clone $start)->endOfDay();

                $gananciasDia = Trade::whereBetween('fecha', [$start, $end])
                    ->where('ganado', true)
                    ->sum('pago') -
                    Trade::whereBetween('fecha', [$start, $end])
                    ->where('ganado', false)
                    ->sum('monto');

                $labelsGanancias[] = $dia;
                $gananciasPorFecha[] = round($gananciasDia, 2);
            }
        } else { // año
            for ($mes = 1; $mes <= 12; $mes++) {
                $start = (clone $fechaInicio)->setMonth($mes)->startOfMonth();
                $end = (clone $start)->endOfMonth();

                $gananciasMes = Trade::whereBetween('fecha', [$start, $end])
                    ->where('ganado', true)
                    ->sum('pago') -
                    Trade::whereBetween('fecha', [$start, $end])
                    ->where('ganado', false)
                    ->sum('monto');

                $labelsGanancias[] = $start->format('M');
                $gananciasPorFecha[] = round($gananciasMes, 2);
            }
        }

        // 3. Monto invertido por día (similar a ganancias, aquí sumamos 'monto' de todas operaciones)
        $montoInvertidoData = [];
        $labelsMonto = $labelsGanancias; // para simplicidad igual labels que ganancias

        if ($tipo === 'dia') {
            for ($hora = 0; $hora < 24; $hora++) {
                $start = (clone $fechaInicio)->setHour($hora)->setMinute(0)->setSecond(0);
                $end = (clone $start)->setMinute(59)->setSecond(59);

                $montoHora = Trade::whereBetween('fecha', [$start, $end])->sum('monto');
                $montoInvertidoData[] = round($montoHora, 2);
            }
        } elseif ($tipo === 'mes') {
            $diasDelMes = $fechaInicio->daysInMonth;
            for ($dia = 1; $dia <= $diasDelMes; $dia++) {
                $start = (clone $fechaInicio)->setDay($dia)->startOfDay();
                $end = (clone $start)->endOfDay();

                $montoDia = Trade::whereBetween('fecha', [$start, $end])->sum('monto');
                $montoInvertidoData[] = round($montoDia, 2);
            }
        } else { // año
            for ($mes = 1; $mes <= 12; $mes++) {
                $start = (clone $fechaInicio)->setMonth($mes)->startOfMonth();
                $end = (clone $start)->endOfMonth();

                $montoMes = Trade::whereBetween('fecha', [$start, $end])->sum('monto');
                $montoInvertidoData[] = round($montoMes, 2);
            }
        }

        $activos = Trade::whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->select('activo')
            ->selectRaw('count(*) as total')
            ->groupBy('activo')
            ->orderByDesc('total')
            ->take(5)
            ->get(); 

        return view('home', [
            'ganados' => $ganados,
            'perdidos' => $perdidos,
            'efectividad' => $efectividad,
            'gananciaNeta' => $gananciaNeta,
            'chartEfectividadData' => $chartEfectividadData,
            'labelsGanancias' => $labelsGanancias,
            'gananciasPorFecha' => $gananciasPorFecha,
            'labelsMonto' => $labelsMonto,
            'montoInvertidoData' => $montoInvertidoData,
            'activosLabels' => $activos->pluck('activo')->toArray(),
            'activosData' => $activos->pluck('total')->toArray(),
            'tipo' => $tipo,
        ]);
    }
}
