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

            $table->unsignedBigInteger('invoice_id');
            $table
                ->foreign('invoice_id')
                ->references('id')
                ->on('invoices')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->string('title');

            $table->unsignedBigInteger('item_id')->nullable();
            $table
                ->foreign('item_id')
                ->references('id')
                ->on('items')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');

            $table->unsignedBigInteger('price_id')->nullable();
            $table
                ->foreign('price_id')
                ->references('id')
                ->on('prices')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');

            $table->unsignedBigInteger('user_id')->nullable();
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');

            $table->unsignedInteger('amount');
            $table->unsignedInteger('discount_fixed');

            $table->text('note')->nullable();            

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
