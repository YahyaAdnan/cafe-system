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
        Schema::create('offer_entities_items', function (Blueprint $table) {            
            $table->id();
            $table->unsignedBigInteger('offer_entity_id');
            $table->unsignedBigInteger('item_id');
    
            $table->foreign('offer_entity_id')->references('id')->on('offer_entities')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_entities_items');
    }
};
