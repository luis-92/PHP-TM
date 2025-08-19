<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('speech_evaluation_details', function (Blueprint $t) {
            $t->id();
            $t->foreignId('speech_evaluation_id')->constrained('speech_evaluations')->cascadeOnDelete();
            $t->foreignId('criterion_id')->constrained('evaluation_criteria')->cascadeOnDelete();
            $t->unsignedTinyInteger('score');
            $t->text('comment')->nullable();
            $t->timestamps();
            $t->unique(['speech_evaluation_id','criterion_id'], 'sed_eval_crit_uq');

        });
    }
    public function down(): void { Schema::dropIfExists('speech_evaluation_details'); }
};
