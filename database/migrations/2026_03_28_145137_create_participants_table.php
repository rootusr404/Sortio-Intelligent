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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('draw_id')->constrained()->onDelete('cascade');
            $table->string('full_name', 255);
            $table->integer('group_id')->nullable();
            $table->string('theme_name', 255)->nullable();
            $table->integer('position_in_draw');
            $table->timestamps();
            
            $table->index('draw_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
