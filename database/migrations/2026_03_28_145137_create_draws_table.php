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
        Schema::create('draws', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title', 255);
            $table->enum('type', ['A', 'B']);
            $table->json('parameters');
            $table->integer('participant_count');
            $table->string('seed', 64);
            $table->text('hash_input_snapshot');
            $table->string('hash_code', 64);
            $table->timestamp('locked_at')->nullable();
            $table->timestamp('anonymized_at')->nullable();
            $table->timestamps();
            
            $table->index('hash_code');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draws');
    }
};
