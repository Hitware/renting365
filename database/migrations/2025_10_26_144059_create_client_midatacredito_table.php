<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_midatacredito', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->timestamp('query_date');
            $table->enum('query_type', ['consulta_completa', 'consulta_score']);
            $table->integer('score')->nullable();
            $table->enum('risk_level', ['bajo', 'medio', 'alto', 'muy_alto'])->nullable();
            $table->integer('active_credits_count')->default(0);
            $table->decimal('total_debt', 15, 2)->default(0);
            $table->decimal('overdue_debt', 15, 2)->default(0);
            $table->enum('worst_status', ['al_dia', 'mora_30', 'mora_60', 'mora_90', 'mora_120', 'castigado'])->default('al_dia');
            $table->integer('credit_cards_count')->default(0);
            $table->date('last_query_date')->nullable();
            $table->integer('inquiries_last_6_months')->default(0);
            $table->boolean('has_legal_proceedings')->default(false);
            $table->json('response_json')->nullable();
            $table->foreignId('queried_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index('client_id');
            $table->index('query_date');
            $table->index('score');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_midatacredito');
    }
};
