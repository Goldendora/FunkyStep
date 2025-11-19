<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usuarios_baneados', function (Blueprint $table) {
            $table->id('id_ban');
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
            $table->string('motivo')->nullable();
            $table->dateTime('fecha_ban')->nullable();
            $table->integer('duracion_dias')->nullable();
            $table->string('baneado_por')->nullable();
            $table->enum('estado', ['activo', 'expirado'])->default('activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios_baneados');
    }
};
