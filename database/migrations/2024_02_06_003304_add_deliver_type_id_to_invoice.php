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
        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('deliver_type_id')->nullable();
            $table
                ->foreign('deliver_type_id')
                ->references('id')
                ->on('deliver_types')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['deliver_type_id']);

            // Drop the column
            $table->dropColumn('deliver_type_id');
        });
    }
};
