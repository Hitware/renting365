<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->enum('reference_type', ['personal', 'familiar', 'comercial']);
            $table->string('full_name', 255);
            $table->string('relationship', 100)->nullable();
            $table->string('phone', 20);
            $table->string('email', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('city', 100)->nullable();
            $table->integer('years_known')->nullable();
            $table->enum('verification_status', ['pendiente', 'en_verificacion', 'verificada', 'no_verificada'])->default('pendiente');
            $table->timestamp('verification_date')->nullable();
            $table->text('verification_notes')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index('client_id');
            $table->index('verification_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_references');
    }
};
