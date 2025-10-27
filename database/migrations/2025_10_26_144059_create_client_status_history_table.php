<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('previous_status', 50)->nullable();
            $table->string('new_status', 50);
            $table->foreignId('changed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('change_reason', 255)->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();

            $table->index('client_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_status_history');
    }
};
