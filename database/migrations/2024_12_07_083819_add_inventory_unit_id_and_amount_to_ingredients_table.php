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
        Schema::table('ingredients', function (Blueprint $table) {
            $table->unsignedBigInteger('inventory_unit_id')->nullable()->after('id'); // Nullable foreign key
            $table->unsignedFloat('amount', 8, 2)->default(0)->after('inventory_unit_id'); // Unsigned float with default 0.00

            // Adding a foreign key constraint
            $table->foreign('inventory_unit_id')->references('id')->on('inventory_units')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ingredients', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['inventory_unit_id']);

            // Drop columns
            $table->dropColumn(['inventory_unit_id', 'amount']);
        });
    }
};
