<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dcp_goal_progress', function (Blueprint $t) {
            $t->id();
            $t->foreignId('club_id')->constrained('clubs')->cascadeOnDelete();
            $t->foreignId('dcp_goal_id')->constrained('dcp_goals')->cascadeOnDelete();
            $t->string('tm_year');
            $t->unsignedTinyInteger('progress')->default(0);
            $t->timestamps();
            $t->unique(['club_id','dcp_goal_id','tm_year'], 'dcp_prog_club_goal_year_uq');

        });
    }
    public function down(): void { Schema::dropIfExists('dcp_goal_progress'); }
};
