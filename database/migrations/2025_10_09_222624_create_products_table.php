<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Información básica del producto
            $table->string('name');                       // Nombre
            $table->text('description')->nullable();       // Descripción
            $table->decimal('price', 10, 2);               // Precio base
            $table->integer('stock')->default(0);          // Inventario actual
            $table->string('image')->nullable();           // Imagen principal

            // Clasificación y detalles comerciales
            $table->string('category')->nullable();        // Categoría (zapatillas, deportivas, casual, etc.)
            $table->string('brand')->nullable();           // Marca (Nike, Adidas, etc.)
            $table->string('sku')->unique();           // Código único del producto
            $table->decimal('discount', 5, 2)->default(0); // Descuento en %

            // Métricas para reportes
            $table->integer('total_sales')->default(0);    // Total de unidades vendidas
            $table->decimal('rating', 3, 2)->nullable();   // Calificación promedio
            $table->boolean('is_active')->default(true);   // Disponible o no para venta

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
