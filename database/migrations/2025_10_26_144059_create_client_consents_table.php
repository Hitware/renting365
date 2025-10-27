<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_consents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->enum('consent_type', ['tratamiento_datos', 'consulta_centrales', 'uso_comercial']);
            $table->text('consent_text');
            $table->boolean('accepted')->default(false);
            $table->timestamp('acceptance_date')->nullable();
            $table->string('acceptance_ip', 45)->nullable();
            $table->string('acceptance_user_agent', 500)->nullable();
            $table->boolean('revoked')->default(false);
            $table->timestamp('revocation_date')->nullable();
            $table->timestamps();

            $table->index('client_id');
            $table->index('consent_type');
            $table->index('accepted');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_consents');
    }
};
