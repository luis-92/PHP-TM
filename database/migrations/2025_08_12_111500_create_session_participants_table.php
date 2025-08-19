<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('session_participants', function (Blueprint $t) {
            $t->id();
            $t->foreignId('club_session_id')->constrained('club_sessions')->cascadeOnDelete();
            $t->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $t->foreignId('visitor_id')->nullable()->constrained('visitors')->nullOnDelete();
            $t->string('category')->nullable();
            $t->timestamps();
            $t->unique(['club_session_id','member_id','visitor_id'], 'spart_session_m_v_uq');

        });
    }
    public function down(): void { Schema::dropIfExists('session_participants'); }
};
