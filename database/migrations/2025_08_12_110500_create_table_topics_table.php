<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('table_topics', function (Blueprint $t) {
            $t->id();
            $t->foreignId('club_session_id')->constrained('club_sessions')->cascadeOnDelete();
            $t->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $t->string('topic')->nullable();
            $t->string('question')->nullable();
            $t->time('real_time')->nullable();
            $t->timestamps();

        });
    }
    public function down(): void { Schema::dropIfExists('table_topics'); }
};
