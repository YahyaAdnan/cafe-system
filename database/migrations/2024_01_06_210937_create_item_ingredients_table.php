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
        Schema::create('item_ingredients', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('item_id');
            $table
                ->foreign('item_id')
                ->references('id')
                ->on('items')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->unsignedBigInteger('ingredient_id');
            $table
                ->foreign('ingredient_id')
                ->references('id')
                ->on('ingredients')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->boolean('main');
            
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_ingredients');
    }
};
