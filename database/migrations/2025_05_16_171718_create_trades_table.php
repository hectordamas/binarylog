<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('user_id'); // Relación con users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('porcentaje', 5, 2)->default(0); // Ej: 80% de retorno

            $table->dateTime('fecha');
            $table->string('activo')->nullable(); // Ej: EUR/USD
            $table->decimal('monto', 8, 2);
            $table->boolean('ganado'); // true = ganado, false = perdido
            $table->decimal('pago', 8, 2); // Si ganó, por ejemplo: 1.8 * monto. Si perdió, 0.
            $table->text('comentario')->nullable();
            $table->string('imagen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
