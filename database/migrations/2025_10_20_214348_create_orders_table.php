<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Usuario dueño del pedido
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();

            // Total pagado (se recalcula en servidor)
            $table->decimal('total', 10, 2)->default(0);

            // Estados: pendiente, pagado, cancelado, fallido
            $table->enum('status', ['pendiente', 'pagado', 'cancelado', 'fallido'])->default('pendiente')->index();

            // Info de pago/proveedor
            $table->string('payment_method', 50)->nullable()->index();   // p.ej., 'stripe'
            $table->string('payment_provider', 50)->nullable()->index(); // p.ej., 'stripe'
            $table->string('payment_reference', 191)->nullable()->unique(); // id de sesión/intent del proveedor

            // Payload crudo del webhook/confirmación (útil para auditoría)
            $table->json('raw_payload')->nullable();

            $table->timestamps();

            // Índices útiles
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
