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
        Schema::create('ingredient_details', function (Blueprint $table) {
            $table->id();
                        
            $table->unsignedBigInteger('ingredient_id');
            $table->unsignedBigInteger('item_ingredients_id');
            $table->unsignedBigInteger('price_id');


            $table->float('amount')->default(0);

            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
            $table->foreign('item_ingredients_id')->references('id')->on('item_ingredients')->onDelete('cascade');
            $table->foreign('price_id')->references('id')->on('prices')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_details');
    }
};
