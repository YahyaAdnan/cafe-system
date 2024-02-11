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
        Schema::table('inventory_records', function (Blueprint $table) {
            $table->unsignedBigInteger('expense_id')->nullable();
            $table
                ->foreign('expense_id')
                ->references('id')
                ->on('expenses')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_records', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['expense_id']);

            // Drop the column
            $table->dropColumn('expense_id');
        });
    }
};
