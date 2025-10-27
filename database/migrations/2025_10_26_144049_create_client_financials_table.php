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
        Schema::create('client_financials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('month_year', 7); // Formato: YYYY-MM
            $table->text('total_income'); // Cifrado
            $table->text('salary_income')->nullable(); // Cifrado
            $table->text('commission_income')->nullable(); // Cifrado
            $table->text('rental_income')->nullable(); // Cifrado
            $table->text('other_income')->nullable(); // Cifrado
            $table->text('total_expenses'); // Cifrado
            $table->text('rent_expense')->nullable(); // Cifrado
            $table->text('utilities_expense')->nullable(); // Cifrado
            $table->text('food_expense')->nullable(); // Cifrado
            $table->text('transport_expense')->nullable(); // Cifrado
            $table->text('education_expense')->nullable(); // Cifrado
            $table->text('credit_payments_expense')->nullable(); // Cifrado
            $table->text('other_expenses')->nullable(); // Cifrado
            $table->text('disposable_income')->nullable(); // Calculado: total_income - total_expenses (Cifrado)
            $table->decimal('debt_to_income_ratio', 5, 2)->nullable(); // Calculado
            $table->text('payment_capacity')->nullable(); // Calculado (Cifrado)
            $table->timestamps();

            // Índices
            $table->index('client_id');
            $table->index('month_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_financials');
    }
};
