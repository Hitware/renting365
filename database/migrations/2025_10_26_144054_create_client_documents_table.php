<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->enum('document_type', ['cedula_frontal', 'cedula_reverso', 'certificado_laboral', 'desprendible_pago', 'extracto_bancario', 'servicio_publico', 'referencia_firmada', 'contrato', 'otro']);
            $table->string('file_name', 255);
            $table->string('file_path', 500);
            $table->integer('file_size');
            $table->string('mime_type', 100);
            $table->integer('version')->default(1);
            $table->timestamp('upload_date')->useCurrent();
            $table->date('expiry_date')->nullable();
            $table->enum('status', ['pendiente', 'en_revision', 'aprobado', 'rechazado'])->default('pendiente');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('review_date')->nullable();
            $table->text('review_comments')->nullable();
            $table->boolean('is_current_version')->default(true);
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            $table->index('client_id');
            $table->index('document_type');
            $table->index('status');
            $table->index('is_current_version');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_documents');
    }
};
