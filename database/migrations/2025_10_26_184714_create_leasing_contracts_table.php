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
        Schema::create('leasing_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number')->unique();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('motorcycle_id')->constrained()->onDelete('restrict');
            $table->decimal('motorcycle_value', 12, 2);
            $table->decimal('initial_payment', 12, 2)->default(0);
            $table->decimal('financed_amount', 12, 2);
            $table->integer('term_months');
            $table->decimal('monthly_rate', 5, 4);
            $table->decimal('monthly_payment', 12, 2);
            $table->integer('payment_day');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['pendiente', 'activo', 'completado', 'mora', 'cancelado'])->default('pendiente');
            $table->string('signed_contract_path')->nullable();
            $table->timestamp('contract_signed_at')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leasing_contracts');
    }
};
