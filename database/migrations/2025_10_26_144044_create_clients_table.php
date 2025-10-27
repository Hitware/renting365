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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('document_type', ['CC', 'CE', 'TI', 'PP']);
            $table->string('document_number', 20)->unique();
            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100);
            $table->string('second_last_name', 100)->nullable();
            $table->string('full_name', 255);
            $table->date('birth_date');
            $table->string('birth_place', 100)->nullable();
            $table->enum('gender', ['M', 'F', 'Otro', 'Prefiero no decir'])->default('Prefiero no decir');
            $table->enum('marital_status', ['soltero', 'casado', 'union_libre', 'divorciado', 'viudo']);
            $table->enum('education_level', ['primaria', 'secundaria', 'tecnico', 'tecnologo', 'profesional', 'posgrado']);
            $table->integer('dependents_count')->default(0);
            $table->enum('status', ['registro_inicial', 'documentacion_pendiente', 'en_revision', 'verificacion_referencias', 'consulta_midatacredito', 'analisis_financiero', 'en_revision_gerencia', 'aprobado', 'rechazado', 'congelado'])->default('registro_inicial');
            $table->foreignId('assigned_analyst_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('credit_score')->nullable();
            $table->timestamp('approval_date')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index('document_number');
            $table->index('status');
            $table->index('assigned_analyst_id');
            $table->index('credit_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
