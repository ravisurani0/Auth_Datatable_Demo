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
        Schema::create('order_has_products', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('order_id')->unsigned()->index();
            $table->foreign('order_id')->references('id')->on('orders');

            $table->bigInteger('product_id')->unsigned()->index();
            $table->foreign('product_id')->references('id')->on('products');

            $table->integer('qnt')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
