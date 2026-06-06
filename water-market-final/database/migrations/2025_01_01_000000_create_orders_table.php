<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('customer_name')->nullable(); // Store name for walk-in sales
            $table->enum('status', ['pending', 'processing', 'out-for-delivery', 'delivered', 'cancelled'])->default('pending');
            $table->decimal('total', 10, 2);
            $table->text('address');
            $table->string('payment_method')->default('Cash');
            $table->string('payment_status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
