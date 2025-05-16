<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Trade;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TradeSeeder extends Seeder
{

    public function run(): void
    {
        $user = User::first(); // Usa el primer usuario existente

        if (!$user) {
            $this->command->error('No hay usuarios en la base de datos. Crea uno primero.');
            return;
        }

        $activos = ['EUR/USD', 'BTC/USD', 'GOLD', 'AAPL', 'ETH/USD'];
        $startDate = now()->subMonths(6); // 6 meses atrás

        for ($i = 0; $i < 150; $i++) {
            $fecha = $startDate->copy()->addDays(rand(0, 180))->addHours(rand(0, 23))->addMinutes(rand(0, 59));

            $monto = rand(10, 100);
            $ganado = rand(0, 1) === 1;
            $pago = $ganado ? $monto * (1.7 + mt_rand(0, 20) / 100) : 0;

            Trade::create([
                'user_id'   => $user->id,
                'fecha'     => $fecha,
                'activo'    => $activos[array_rand($activos)],
                'monto'     => $monto,
                'ganado'    => $ganado,
                'pago'      => $pago,
                'comentario'=> fake()->optional()->sentence(),
                'imagen'    => null,
            ]);
        }

        $this->command->info('Se generaron 150 trades de prueba.');
    }
}
