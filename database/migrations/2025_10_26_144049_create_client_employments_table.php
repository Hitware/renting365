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
        Schema::create('client_employments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->boolean('is_current')->default(true);
            $table->enum('employment_type', ['empleado_indefinido', 'empleado_temporal', 'prestacion_servicios', 'independiente', 'pensionado'])->nullable();
            $table->string('employer_name', 255)->nullable();
            $table->string('employer_nit', 20)->nullable();
            $table->string('employer_phone', 20)->nullable();
            $table->string('employer_address', 255)->nullable();
            $table->string('employer_city', 100)->nullable();
            $table->string('position', 100)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('monthly_salary')->nullable(); // Cifrado
            $table->text('other_income')->nullable(); // Cifrado
            $table->text('total_monthly_income')->nullable(); // Cifrado
            $table->enum('contract_type', ['indefinido', 'fijo', 'obra_labor', 'prestacion_servicios'])->nullable();
            $table->timestamps();

            // Índices
            $table->index('client_id');
            $table->index('is_current');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_employments');
    }
};
