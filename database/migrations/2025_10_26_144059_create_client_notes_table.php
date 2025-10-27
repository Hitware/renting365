<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->enum('note_type', ['general', 'llamada', 'reunion', 'seguimiento', 'alerta']);
            $table->text('note_content');
            $table->boolean('is_important')->default(false);
            $table->boolean('is_private')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index('client_id');
            $table->index('note_type');
            $table->index('is_important');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_notes');
    }
};
