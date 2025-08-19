<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('speeches', function (Blueprint $t) {
            $t->id();
            $t->foreignId('club_session_id')->constrained('club_sessions')->cascadeOnDelete();
            $t->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $t->string('title')->nullable();
            $t->string('pathways_level')->nullable();
            $t->text('objective')->nullable();
            $t->time('real_time')->nullable();
            $t->timestamps();
            $t->index(['club_session_id','member_id']);

        });
    }
    public function down(): void { Schema::dropIfExists('speeches'); }
};
