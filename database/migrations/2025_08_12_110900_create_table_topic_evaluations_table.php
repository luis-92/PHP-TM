<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('table_topic_evaluations', function (Blueprint $t) {
            $t->id();
            $t->foreignId('club_session_id')->constrained('club_sessions')->cascadeOnDelete();
            $t->foreignId('table_topic_id')->constrained('table_topics')->cascadeOnDelete();
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
            $t->unique(['table_topic_id','evaluator_id'], 'tteval_topic_eval_uq');

        });
    }
    public function down(): void { Schema::dropIfExists('table_topic_evaluations'); }
};
