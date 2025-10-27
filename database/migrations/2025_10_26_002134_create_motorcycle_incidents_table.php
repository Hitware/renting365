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
        Schema::create('motorcycle_incidents', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('motorcycle_id')
                ->constrained('motorcycles')
                ->cascadeOnDelete()
                ->comment('Motocicleta');

            $table->foreignId('driver_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->comment('Conductor involucrado');

            // Incident Type and Severity
            $table->enum('type', ['accident', 'theft', 'damage', 'loss', 'other'])
                ->default('accident')
                ->comment('Tipo de siniestro');

            $table->enum('severity', ['minor', 'moderate', 'severe', 'total_loss'])
                ->default('minor')
                ->comment('Gravedad del siniestro');

            // Incident Details
            $table->string('title')->comment('Título del siniestro');
            $table->text('description')->comment('Descripción detallada');
            $table->date('incident_date')->comment('Fecha del siniestro');
            $table->time('incident_time')->nullable()->comment('Hora del siniestro');

            // Location
            $table->string('location')->nullable()->comment('Ubicación del siniestro');
            $table->decimal('latitude', 10, 7)->nullable()->comment('Latitud');
            $table->decimal('longitude', 10, 7)->nullable()->comment('Longitud');

            // Insurance and Police
            $table->boolean('police_report_filed')->default(false)->comment('Se presentó denuncia policial');
            $table->string('police_report_number')->nullable()->comment('Número de denuncia');
            $table->boolean('insurance_claim_filed')->default(false)->comment('Se presentó reclamación al seguro');
            $table->string('insurance_claim_number')->nullable()->comment('Número de reclamación');

            // Costs
            $table->decimal('estimated_damage_cost', 12, 2)->nullable()->comment('Costo estimado de daños');
            $table->decimal('actual_repair_cost', 12, 2)->nullable()->comment('Costo real de reparación');
            $table->decimal('insurance_coverage', 12, 2)->nullable()->comment('Cobertura del seguro');

            // Status
            $table->enum('status', ['reported', 'under_investigation', 'in_repair', 'resolved', 'closed'])
                ->default('reported')
                ->comment('Estado del siniestro');

            // Resolution
            $table->date('resolution_date')->nullable()->comment('Fecha de resolución');
            $table->text('resolution_notes')->nullable()->comment('Notas de resolución');

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
            $table->index('driver_id');
            $table->index('type');
            $table->index('severity');
            $table->index('status');
            $table->index('incident_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motorcycle_incidents');
    }
};
