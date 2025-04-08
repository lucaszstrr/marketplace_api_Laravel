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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(('orders_couponid_foreign'));

            $table->unsignedBigInteger('couponId')->nullable()->change();
            $table->foreign('couponId')->references('id')->on('coupons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(('orders_couponid_foreign'));

            $table->unsignedBigInteger('couponId')->change();
            $table->foreign('couponId')->references('id')->on('coupons');
        });
    }
};
