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
        Schema::create('leasing_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leasing_contract_id')->constrained()->onDelete('cascade');
            $table->integer('payment_number');
            $table->date('due_date');
            $table->decimal('amount', 12, 2);
            $table->decimal('principal', 12, 2);
            $table->decimal('interest', 12, 2);
            $table->decimal('balance', 12, 2);
            $table->enum('status', ['pendiente', 'pagado', 'vencido', 'parcial'])->default('pendiente');
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->date('paid_date')->nullable();
            $table->string('payment_reference')->nullable();
            $table->text('payment_notes')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leasing_payments');
    }
};
