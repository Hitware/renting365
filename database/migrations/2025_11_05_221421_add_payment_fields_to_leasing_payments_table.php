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
        Schema::table('leasing_payments', function (Blueprint $table) {
            $table->timestamp('paid_at')->nullable()->after('status');
            $table->decimal('amount_paid', 10, 2)->nullable()->after('paid_at');
            $table->string('payment_method', 50)->nullable()->after('amount_paid');
            $table->string('reference_number', 100)->nullable()->after('payment_method');
            $table->foreignId('received_by')->nullable()->after('reference_number')->constrained('users');
            $table->text('notes')->nullable()->after('received_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leasing_payments', function (Blueprint $table) {
            $table->dropForeign(['received_by']);
            $table->dropColumn(['paid_at', 'amount_paid', 'payment_method', 'reference_number', 'received_by', 'notes']);
        });
    }
};
