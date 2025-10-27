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
        Schema::create('motorcycles', function (Blueprint $table) {
            $table->id();

            // Technical Data
            $table->string('brand')->comment('Marca de la motocicleta');
            $table->string('model')->comment('Modelo');
            $table->string('year', 4)->comment('Año de fabricación');
            $table->string('displacement')->comment('Cilindraje (e.g., 150cc, 200cc)');
            $table->string('plate')->unique()->comment('Placa única');
            $table->string('motor_number')->unique()->comment('Número de motor único');
            $table->string('chassis_number')->unique()->comment('Número de chasis único');
            $table->string('color')->nullable()->comment('Color');

            // Status
            $table->enum('status', ['active', 'in_maintenance', 'damaged', 'sold', 'inactive'])
                ->default('active')
                ->comment('Estado actual de la moto');

            // Current Assignment
            $table->foreignId('current_owner_id')->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->comment('Propietario/responsable actual');

            // Purchase Information
            $table->decimal('purchase_price', 12, 2)->nullable()->comment('Precio de compra');
            $table->date('purchase_date')->nullable()->comment('Fecha de compra');

            // Metadata
            $table->text('notes')->nullable()->comment('Notas adicionales');
            $table->foreignId('created_by')->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('updated_by')->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('status');
            $table->index('brand');
            $table->index('current_owner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motorcycles');
    }
};
