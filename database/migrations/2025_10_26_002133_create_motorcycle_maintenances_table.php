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
        Schema::create('motorcycle_maintenances', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('motorcycle_id')
                ->constrained('motorcycles')
                ->cascadeOnDelete()
                ->comment('Motocicleta');

            // Maintenance Type
            $table->enum('type', ['preventive', 'corrective', 'inspection', 'other'])
                ->default('preventive')
                ->comment('Tipo de mantenimiento');

            // Maintenance Details
            $table->string('title')->comment('Título del mantenimiento');
            $table->text('description')->nullable()->comment('Descripción detallada');

            // Dates and Status
            $table->date('scheduled_date')->comment('Fecha programada');
            $table->date('completed_date')->nullable()->comment('Fecha de completado');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])
                ->default('pending')
                ->comment('Estado del mantenimiento');

            // Service Provider
            $table->string('workshop_name')->nullable()->comment('Nombre del taller');
            $table->string('technician_name')->nullable()->comment('Nombre del técnico');

            // Costs
            $table->decimal('estimated_cost', 12, 2)->nullable()->comment('Costo estimado');
            $table->decimal('actual_cost', 12, 2)->nullable()->comment('Costo real');

            // Mileage
            $table->integer('mileage_km')->nullable()->comment('Kilometraje al momento del servicio');

            // Next Maintenance
            $table->date('next_maintenance_date')->nullable()->comment('Fecha próximo mantenimiento');
            $table->integer('next_maintenance_km')->nullable()->comment('Kilometraje próximo mantenimiento');

            // Notes
            $table->text('notes')->nullable()->comment('Notas adicionales');

            // Metadata
            $table->foreignId('registered_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->comment('Usuario que registró');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('motorcycle_id');
            $table->index('type');
            $table->index('status');
            $table->index('scheduled_date');
            $table->index('completed_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motorcycle_maintenances');
    }
};
