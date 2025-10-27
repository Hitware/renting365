<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_credits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->enum('credit_source', ['renting365', 'banco', 'cooperativa', 'tarjeta_credito', 'otro']);
            $table->string('entity_name', 255);
            $table->enum('credit_type', ['consumo', 'vivienda', 'vehiculo', 'tarjeta_credito', 'microcredito']);
            $table->decimal('original_amount', 15, 2);
            $table->decimal('current_balance', 15, 2);
            $table->decimal('monthly_payment', 15, 2);
            $table->integer('payment_day')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['activo', 'pagado', 'mora', 'castigado'])->default('activo');
            $table->integer('days_overdue')->default(0);
            $table->boolean('reported_to_credit_bureau')->default(false);
            $table->timestamps();

            $table->index('client_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_credits');
    }
};
