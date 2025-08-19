<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('club_sessions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('club_id')->constrained('clubs')->cascadeOnDelete();
            $t->date('date');
            $t->string('session_type')->nullable();
            $t->string('location')->nullable();
            $t->time('planned_time')->nullable();
            $t->time('start_time')->nullable();
            $t->time('end_time')->nullable();
            $t->string('notes')->nullable();
            $t->timestamps();
            $t->unique(['club_id','date'], 'club_session_day_uq');

        });
    }
    public function down(): void { Schema::dropIfExists('club_sessions'); }
};
