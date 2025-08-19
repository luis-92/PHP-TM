<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('attendance', function (Blueprint $t) {
            $t->id();
            $t->foreignId('club_session_id')->constrained('club_sessions')->cascadeOnDelete();
            $t->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $t->enum('status',['present','absent','guest'])->default('present');
            $t->timestamps();
            $t->unique(['club_session_id','member_id'], 'att_session_member_uq');

        });
    }
    public function down(): void { Schema::dropIfExists('attendance'); }
};
