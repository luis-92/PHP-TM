<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('session_club_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('toastmasters_sessions')->onDelete('cascade');
            $table->foreignId('evaluator_id')->constrained('members')->onDelete('cascade'); // Quién evalúa
            $table->text('comments');
            $table->integer('rating')->default(5); // Escala de 1 a 5
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_club_evaluations');
    }
};
