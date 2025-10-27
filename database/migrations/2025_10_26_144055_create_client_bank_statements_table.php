<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_bank_statements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('client_document_id')->nullable()->constrained('client_documents')->onDelete('set null');
            $table->string('bank_name', 100);
            $table->enum('account_type', ['ahorros', 'corriente']);
            $table->string('account_number_last4', 4);
            $table->integer('statement_month');
            $table->integer('statement_year');
            $table->decimal('opening_balance', 15, 2)->default(0);
            $table->decimal('closing_balance', 15, 2)->default(0);
            $table->decimal('average_balance', 15, 2)->nullable();
            $table->decimal('total_deposits', 15, 2)->default(0);
            $table->decimal('total_withdrawals', 15, 2)->default(0);
            $table->integer('deposit_count')->default(0);
            $table->integer('withdrawal_count')->default(0);
            $table->integer('overdraft_count')->default(0);
            $table->boolean('salary_detected')->default(false);
            $table->text('salary_amount')->nullable(); // Cifrado
            $table->enum('analysis_status', ['pendiente', 'analizado'])->default('pendiente');
            $table->timestamp('analyzed_at')->nullable();
            $table->foreignId('analyzed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index('client_id');
            $table->index(['statement_year', 'statement_month']);
            $table->index('analysis_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_bank_statements');
    }
};
