<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('club_sessions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('club_id')->constrained('clubs')->cascadeOnDelete();
            $t->date('session_date');
            $t->time('start_time')->nullable();
            $t->time('end_time')->nullable();
            $t->string('theme')->nullable();
            $t->string('location')->nullable();
            $t->text('agenda_notes')->nullable();
            $t->timestamps();

            $t->unique(['club_id', 'session_date']); // 1 sesión por día por club
        });
    }

    public function down(): void {
        Schema::dropIfExists('club_sessions');
    }
};
