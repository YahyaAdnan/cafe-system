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
        Schema::create('daily_sale_invoices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('daily_sale_id');
            $table
                ->foreign('daily_sale_id')
                ->references('id')
                ->on('daily_sales')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->unsignedBigInteger('invoice_id');
            $table
                ->foreign('GenerateDailySale')
                ->references('id')
                ->on('invoices')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_sale_invoices');
    }
};
