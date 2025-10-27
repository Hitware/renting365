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
        Schema::create('motorcycle_owners', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('motorcycle_id')
                ->constrained('motorcycles')
                ->cascadeOnDelete()
                ->comment('Motocicleta');

            $table->foreignId('owner_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->comment('Propietario/responsable');

            // Ownership Period
            $table->date('start_date')->comment('Fecha de inicio de propiedad');
            $table->date('end_date')->nullable()->comment('Fecha de fin (null si es actual)');

            // Transfer Information
            $table->enum('transfer_type', ['purchase', 'assignment', 'return', 'sale', 'other'])
                ->default('assignment')
                ->comment('Tipo de transferencia');

            $table->text('notes')->nullable()->comment('Notas sobre la transferencia');

            // Metadata
            $table->foreignId('registered_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->comment('Usuario que registró la transferencia');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('motorcycle_id');
            $table->index('owner_id');
            $table->index('start_date');
            $table->index('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motorcycle_owners');
    }
};
