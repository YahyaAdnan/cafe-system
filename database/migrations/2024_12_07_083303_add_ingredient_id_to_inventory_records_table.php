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
            $table->unsignedBigInteger('ingredient_id')->nullable()->after('id'); // Adjust position with `after()` if needed.

            // Add a foreign key constraint (optional)
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
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
            // Drop the foreign key first
            $table->dropForeign(['ingredient_id']);

            // Then drop the column
            $table->dropColumn('ingredient_id');
        });
    }
};
