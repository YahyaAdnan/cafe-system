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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->string('inovice_no');
            $table->string('title');

            $table->boolean('dinning_in');

            $table->unsignedBigInteger('table_id')->nullable();
            $table
                ->foreign('table_id')
                ->references('id')
                ->on('tables')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');

            $table->unsignedInteger('amount');
            $table->unsignedInteger('remaining');

            $table->unsignedInteger('discount_rate');
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
        Schema::dropIfExists('invoices');
    }
};
