<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('member_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('toastmasters_sessions')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade'); // Miembro evaluado
            $table->foreignId('evaluator_id')->constrained('members')->onDelete('cascade'); // Evaluador
            
            // Tipo de evaluación
            $table->enum('evaluation_type', ['prepared_speech', 'table_topic_speech'])->default('prepared_speech');

            // 🔹 Criterios de evaluación (Ambos tipos de discurso)
            $table->integer('clarity')->default(3); // 1-5
            $table->integer('vocal_variety')->default(3); // 1-5
            $table->integer('eye_contact')->default(3); // 1-5
            $table->integer('gestures')->default(3); // 1-5
            $table->integer('audience_awareness')->default(3); // 1-5
            $table->integer('comfort_level')->default(3); // 1-5
            $table->integer('interest')->default(3); // 1-5

            // 🔹 Criterios específicos para discurso preparado
            $table->integer('applied_feedback')->nullable(); // 1-5, solo si es un segundo discurso
            $table->integer('well_researched')->nullable(); // 1-5, solo para discursos con investigación

            // 🔹 Criterios específicos para table topics
            $table->integer('spontaneity')->nullable(); // 1-5, aplica solo para table topics
            $table->integer('structure')->nullable(); // 1-5, coherencia en la respuesta de table topics

            $table->text('feedback')->nullable(); // Comentarios del evaluador
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_evaluations');
    }
};
