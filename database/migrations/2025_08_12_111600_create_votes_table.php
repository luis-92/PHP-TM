<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('votes', function (Blueprint $t) {
            $t->id();
            $t->foreignId('club_session_id')->constrained('club_sessions')->cascadeOnDelete();
            $t->foreignId('participant_id')->constrained('session_participants')->cascadeOnDelete();
            $t->unsignedTinyInteger('form_score')->nullable();
            $t->unsignedTinyInteger('development_score')->nullable();
            $t->unsignedTinyInteger('topic_score')->nullable();
            $t->boolean('within_time')->default(true);
            $t->boolean('word_of_the_day_used')->default(false);
            $t->string('final_position')->nullable();
            $t->text('comment')->nullable();
            $t->timestamps();

        });
    }
    public function down(): void { Schema::dropIfExists('votes'); }
};
