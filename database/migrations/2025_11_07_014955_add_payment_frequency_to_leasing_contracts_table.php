<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leasing_contracts', function (Blueprint $table) {
            $table->enum('payment_frequency', ['diaria', 'semanal', 'quincenal', 'mensual'])->default('mensual')->after('payment_day');
        });
    }

    public function down(): void
    {
        Schema::table('leasing_contracts', function (Blueprint $table) {
            $table->dropColumn('payment_frequency');
        });
    }
};
