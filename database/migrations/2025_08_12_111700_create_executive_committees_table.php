<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('executive_committees', function (Blueprint $t) {
            $t->id();
            $t->foreignId('club_id')->constrained('clubs')->cascadeOnDelete();
            $t->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $t->string('committee_role');
            $t->date('start_date');
            $t->date('end_date')->nullable();
            $t->text('notes')->nullable();
            $t->timestamps();
            $t->unique(['club_id','committee_role','start_date'], 'exec_role_start_uq');

        });
    }
    public function down(): void { Schema::dropIfExists('executive_committees'); }
};
