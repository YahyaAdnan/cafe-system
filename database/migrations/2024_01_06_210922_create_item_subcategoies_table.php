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
        Schema::create('item_subcategories', function (Blueprint $table) {
            $table->id();
            $table->string('title');

            $table->unsignedBigInteger('item_category_id');
            $table
                ->foreign('item_category_id')
                ->references('id')
                ->on('item_categories')
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
        Schema::dropIfExists('item_subcategories');
    }
};
