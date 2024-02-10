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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            
            $table->unsignedInteger('quantity')->default(0);

            $table->unsignedBigInteger('inventory_unit_id');
            $table
                ->foreign('inventory_unit_id')
                ->references('id')
                ->on('inventory_units')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE'); 
            

            $table->unsignedBigInteger('user_id');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE'); 
            
            $table->string('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
