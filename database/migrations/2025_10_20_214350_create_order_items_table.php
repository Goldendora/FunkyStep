<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Relación con order
            $table->foreignId('order_id')->constrained('orders')->cascadeOnUpdate()->cascadeOnDelete();

            // Producto comprado
            $table->foreignId('product_id')->constrained('products')->cascadeOnUpdate()->restrictOnDelete();

            // Datos inmutables del momento de la compra
            $table->unsignedInteger('quantity');
            $table->decimal('price', 10, 2);    // precio unitario ya con descuento (copiado de cart_items.price)
            $table->decimal('subtotal', 10, 2); // quantity * price

            $table->timestamps();

            // Índices útiles
            $table->index(['order_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
