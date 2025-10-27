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
        Schema::create('motorcycle_documents', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('motorcycle_id')
                ->constrained('motorcycles')
                ->cascadeOnDelete()
                ->comment('Motocicleta');

            // Document Type
            $table->enum('document_type', [
                'soat',                    // Seguro Obligatorio de Accidentes de Tránsito
                'technical_inspection',     // Revisión Técnico Mecánica
                'ownership_card',          // Tarjeta de Propiedad
                'insurance_policy',        // Póliza de Seguro
                'purchase_invoice',        // Factura de Compra
                'transfer_document',       // Documento de Traspaso
                'maintenance_record',      // Registro de Mantenimiento
                'incident_report',         // Reporte de Siniestro
                'other'                    // Otros
            ])->comment('Tipo de documento');

            // Document Information
            $table->string('document_number')->nullable()->comment('Número de documento');
            $table->string('title')->comment('Título del documento');
            $table->text('description')->nullable()->comment('Descripción');

            // File Storage
            $table->string('file_path')->comment('Ruta del archivo');
            $table->string('file_name')->comment('Nombre original del archivo');
            $table->string('file_extension', 10)->comment('Extensión del archivo');
            $table->unsignedBigInteger('file_size')->comment('Tamaño del archivo en bytes');
            $table->string('mime_type')->comment('Tipo MIME del archivo');

            // Validity Period
            $table->date('issue_date')->nullable()->comment('Fecha de emisión');
            $table->date('expiration_date')->nullable()->comment('Fecha de vencimiento');

            // Issuing Authority
            $table->string('issuing_authority')->nullable()->comment('Entidad emisora');

            // Status
            $table->enum('status', ['active', 'expired', 'cancelled', 'replaced'])
                ->default('active')
                ->comment('Estado del documento');

            // Replacement tracking
            $table->foreignId('replaces_document_id')
                ->nullable()
                ->constrained('motorcycle_documents')
                ->nullOnDelete()
                ->comment('Documento que reemplaza');

            // Metadata
            $table->foreignId('uploaded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->comment('Usuario que cargó el documento');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('motorcycle_id');
            $table->index('document_type');
            $table->index('status');
            $table->index('expiration_date');
            $table->index('issue_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motorcycle_documents');
    }
};
