<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_bank_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_statement_id')->constrained('client_bank_statements')->onDelete('cascade');
            $table->date('transaction_date');
            $table->string('description', 500);
            $table->enum('transaction_type', ['deposito', 'retiro', 'transferencia', 'pago_servicio']);
            $table->decimal('amount', 15, 2);
            $table->decimal('balance', 15, 2);
            $table->boolean('is_recurrent')->default(false);
            $table->enum('category', ['salario', 'arriendo', 'servicios', 'alimentacion', 'transporte', 'otro'])->default('otro');
            $table->timestamps();

            $table->index('bank_statement_id');
            $table->index('transaction_date');
            $table->index('transaction_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_bank_transactions');
    }
};
