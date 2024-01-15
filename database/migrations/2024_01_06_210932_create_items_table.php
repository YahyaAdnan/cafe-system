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
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('image');

            $table->boolean('is_available');
            $table->boolean('show');
            $table->boolean('show_ingredients');

            $table->unsignedBigInteger('item_type_id');
            $table
                ->foreign('item_type_id')
                ->references('id')
                ->on('item_types')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->unsignedBigInteger('item_category_id');
            $table
                ->foreign('item_category_id')
                ->references('id')
                ->on('item_categories')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->unsignedBigInteger('item_subcategory_id');
            $table
                ->foreign('item_subcategory_id')
                ->references('id')
                ->on('item_subcategories')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
