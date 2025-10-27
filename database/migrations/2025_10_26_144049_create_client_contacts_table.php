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
        Schema::create('client_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->enum('contact_type', ['residencia', 'trabajo', 'correspondencia', 'otro'])->default('residencia');
            $table->string('address', 255);
            $table->string('neighborhood', 100)->nullable();
            $table->string('city', 100);
            $table->string('department', 100);
            $table->string('country', 100)->default('Colombia');
            $table->string('postal_code', 20)->nullable();
            $table->string('phone_landline', 20)->nullable();
            $table->string('phone_mobile', 20);
            $table->string('email', 255);
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verification_date')->nullable();
            $table->timestamps();

            // Índices
            $table->index('client_id');
            $table->index('email');
            $table->index('phone_mobile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_contacts');
    }
};
