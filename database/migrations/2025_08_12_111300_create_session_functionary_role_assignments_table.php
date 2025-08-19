<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('session_functionary_role_assignments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('club_session_id')->constrained('club_sessions')->cascadeOnDelete();
            $t->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $t->foreignId('functionary_role_id')->constrained('functionary_roles')->cascadeOnDelete();
            $t->unsignedTinyInteger('slot')->default(1);
            $t->text('notes')->nullable();
            $t->timestamps();
            $t->unique(['club_session_id','functionary_role_id','slot'], 'sfr_session_role_slot_uq');

        });
    }
    public function down(): void { Schema::dropIfExists('session_functionary_role_assignments'); }
};
