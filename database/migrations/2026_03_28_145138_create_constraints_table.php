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
        Schema::create('constraints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('draw_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['inclusion', 'exclusion']);
            $table->json('participant_ids');
            $table->boolean('satisfied')->default(false);
            $table->text('failure_reason')->nullable();
            $table->timestamps();
            
            $table->index('draw_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('constraints');
    }
};
