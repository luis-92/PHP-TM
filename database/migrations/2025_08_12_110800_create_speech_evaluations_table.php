<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('speech_evaluations', function (Blueprint $t) {
            $t->id();
            $t->foreignId('club_session_id')->constrained('club_sessions')->cascadeOnDelete();
            $t->foreignId('speech_id')->constrained('speeches')->cascadeOnDelete();
            $t->foreignId('evaluator_id')->constrained('members')->cascadeOnDelete();
            $t->foreignId('evaluatee_member_id')->constrained('members')->cascadeOnDelete();
            $t->foreignId('evaluation_type_id')->constrained('evaluation_types')->cascadeOnDelete();
            $t->text('observations')->nullable();
            $t->text('strengths')->nullable();
            $t->text('areas_of_improvement')->nullable();
            $t->text('recommendations')->nullable();
            $t->dateTime('date_issued')->nullable();
            $t->dateTime('date_received')->nullable();
            $t->boolean('receiver_confirmation')->default(false);
            $t->timestamps();
            $t->unique(['speech_id','evaluator_id'], 'seval_speech_eval_uq');

        });
    }
    public function down(): void { Schema::dropIfExists('speech_evaluations'); }
};
