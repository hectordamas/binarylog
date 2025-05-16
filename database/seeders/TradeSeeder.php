<?php

namespace Database\Seeders;

use App\Models\Trade;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TradeSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first(); // Asegúrate de que exista al menos un usuario

        $activos = ['EUR/USD', 'USD/JPY', 'GBP/USD', 'BTC/USD', 'ETH/USD'];
        $imagenes = ['trade1.jpg', 'trade2.jpg', 'trade3.jpg', null, null]; // null = sin imagen

        for ($i = 0; $i < 50; $i++) {
            $monto = rand(10, 100);
            $ganado = rand(0, 1);
            $porcentaje = rand(70, 90);
            $pago = $ganado ? round($monto * ($porcentaje / 100), 2) : 0;

            Trade::create([
                'user_id'    => $user->id,
                'fecha'      => now()->subDays(rand(0, 30))->setTime(rand(0, 23), rand(0, 59)),
                'activo'     => $activos[array_rand($activos)],
                'monto'      => $monto,
                'ganado'     => $ganado,
                'pago'       => $pago,
                'porcentaje' => $porcentaje,
                'comentario' => Str::random(20),
                'imagen'     => $imagenes[array_rand($imagenes)],
            ]);
        }
    }
}
