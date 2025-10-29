<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('document_number')->unique();
            $table->string('phone');
            $table->string('email');
            $table->string('city');
            $table->string('motorcycle_type');
            $table->decimal('approximate_value', 10, 2);
            $table->enum('status', ['pending', 'in_study', 'approved', 'rejected'])->default('pending');
            $table->foreignId('assigned_advisor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_applications');
    }
};
