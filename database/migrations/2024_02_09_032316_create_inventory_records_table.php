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
        Schema::create('inventory_records', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('inventory_id');
            $table
                ->foreign('inventory_id')
                ->references('id')
                ->on('inventories')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE'); 
            
            $table->string('source');
            
            $table->unsignedInteger('quantity')->default(0);
            
            $table->enum('type', ['Increase', 'Decrease']);

            $table->unsignedBigInteger('user_id');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('inventory_records');
    }
};
