<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->date('date')->nullable();
            $table->unsignedTinyInteger('grammar')->nullable();
            $table->unsignedTinyInteger('filler_words')->nullable();
            $table->unsignedTinyInteger('body_language')->nullable();
            $table->unsignedTinyInteger('structure')->nullable();
            $table->unsignedTinyInteger('timing')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_progress');
    }
};
