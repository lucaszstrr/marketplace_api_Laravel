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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userId')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('addressId')->constrained('address')->onDelete('cascade')->onUpdate('cascade');
            $table->datetime('orderDate')->useCurrent();
            $table->foreignId('couponId')->constrained('coupons');
            $table->enum('status', ['pending', 'processing', 'shipped', 'completed', 'canceled'])
                ->default('pending');
            $table->decimal('totalAmount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
