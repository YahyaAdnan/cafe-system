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
            $table->dropColumn('source');

            $table->unsignedBigInteger('supplier_id')->nullable();
            $table
                ->foreign('supplier_id')
                    ->references('id')
                    ->on('suppliers')
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
            $table->string('source')->nullable();

            // Drop the foreign key constraint
            $table->dropForeign(['supplier_id']);

            // Drop the column
            $table->dropColumn('supplier_id');
        });
    }
};
