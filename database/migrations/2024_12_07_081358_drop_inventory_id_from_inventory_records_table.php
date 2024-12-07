<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('inventory_records', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['inventory_id']);
            
            // Then drop the column
            $table->dropColumn('inventory_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_records', function (Blueprint $table) {
            // Add the column back
            $table->unsignedBigInteger('inventory_id')->nullable();

            // Restore the foreign key constraint
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');
        });
    }
};
