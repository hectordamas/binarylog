<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Trade};
use Auth;

class TradeController extends Controller
{
    public function index(Request $request)
    {
        $query = Trade::query();
    
        if ($request->fecha_desde) {
            $query->whereDate('fecha', '>=', $request->fecha_desde);
        }
    
        if ($request->fecha_hasta) {
            $query->whereDate('fecha', '<=', $request->fecha_hasta);
        }
    
        if ($request->activo) {
            $query->where('activo', 'like', '%' . $request->activo . '%');
        }
    

        if ($request->filled('ganado')) {
            if ($request->ganado === '1') {
                $query->where('ganado', true);
            } elseif ($request->ganado === '0') {
                $query->where('ganado', false);
            }
        }
        // Clonar la query para métricas antes de paginar
        $queryMetrics = clone $query;
    
        $totalTrades = $queryMetrics->count();
    
        $tradesGanados = (clone $queryMetrics)->where('ganado', true)->count();
        $tradesPerdidos = (clone $queryMetrics)->where('ganado', false)->count();
    
        // Efectividad en porcentaje (evitar división por cero)
        $efectividad = $totalTrades > 0 ? round(($tradesGanados / $totalTrades) * 100, 2) : 0;
    
        // Ganancia Neta: suma de pago si ganado, menos monto si perdido
        $gananciaGanada = (clone $queryMetrics)->where('ganado', true)->sum('pago');
        $perdida = (clone $queryMetrics)->where('ganado', false)->sum('monto');
    
        $gananciaNeta = $gananciaGanada - $perdida;
    
        // Obtener trades paginados
        $trades = $query->orderBy('id', 'desc')->get();
    
        return view('trades.index', compact('trades', 'efectividad', 'tradesGanados', 'tradesPerdidos', 'gananciaNeta'));
    }

    public function store(Request $request)
    {

        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('trades_img'), $filename);
            $imagenPath = 'trades_img/' . $filename; // Ruta relativa para usar en la vista
        }

        $monto = $request->input('monto');
        $ganado = $request->has('ganado');
        $porcentaje = $request->input('porcentaje');
        $pago = $request->boolean('pago');    

        Trade::create([
            'user_id' => Auth::id(),
            'fecha' => $request->input('fecha'),
            'activo' => $request->input('activo'),
            'monto' => $monto,
            'ganado' => $ganado,
            'pago' => $pago,
            'comentario' => $request->input('comentario'),
            'imagen' => $imagenPath,
        ]);

        return redirect()->route('trades.index')->with('success', 'Trade registrado correctamente.');
    }

    public function edit(Trade $trade)
    {
        return view('trades.edit', compact('trade'));
    }

    public function update(Request $request, Trade $trade)
    {
        $data = $request->validate([
            'fecha' => 'required|date',
            'activo' => 'required|string',
            'monto' => 'required|numeric',
            'ganado' => 'nullable|boolean',
            'pago' => 'required|numeric',
            'porcentaje' => 'nullable|numeric',
            'comentario' => 'nullable|string',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->move(public_path('uploads/trades'), $nombreImagen);
            $data['imagen'] = $nombreImagen;
        }

        $data['ganado'] = $request->has('ganado');

        $trade->update($data);

        return redirect()->route('trades.index')->with('success', 'Trade actualizado correctamente.');
    }

    public function destroy($id)
    {
        $trade = Trade::findOrFail($id);
    
        // Eliminar imagen si existe
        if ($trade->imagen && file_exists(public_path('uploads/trades/' . $trade->imagen))) {
            unlink(public_path('uploads/trades/' . $trade->imagen));
        }
    
        // Eliminar el trade
        $trade->delete();
    
        return redirect()->route('trades.index')->with('success', 'Trade eliminado correctamente.');
    }
}
