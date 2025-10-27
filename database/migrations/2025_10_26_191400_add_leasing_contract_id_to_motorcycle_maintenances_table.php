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
        Schema::table('motorcycle_maintenances', function (Blueprint $table) {
            $table->foreignId('leasing_contract_id')->nullable()->after('motorcycle_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('motorcycle_maintenances', function (Blueprint $table) {
            $table->dropForeign(['leasing_contract_id']);
            $table->dropColumn('leasing_contract_id');
        });
    }
};
