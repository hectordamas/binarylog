<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Trade};

class TradeController extends Controller
{
    public function index()
    {
        return view('trades.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'activo' => 'nullable|string|max:255',
            'monto' => 'required|numeric|min:0',
            'ganado' => 'required|boolean',
            'comentario' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

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

        return redirect()->route('trades.create')->with('success', 'Trade registrado correctamente.');
    }
}
