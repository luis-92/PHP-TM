<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('clubs', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->unsignedInteger('club_number')->nullable()->unique();
            $t->string('area')->nullable();
            $t->string('division')->nullable();
            $t->unsignedInteger('district')->nullable();
            $t->date('founding_date')->nullable();
            $t->string('location')->nullable();
            $t->string('language')->nullable();
            $t->string('meeting_days')->nullable();
            $t->string('schedule')->nullable();
            $t->string('modality_meeting')->nullable();
            $t->string('zoom_link')->nullable();
            $t->timestamps();

        });
    }
    public function down(): void { Schema::dropIfExists('clubs'); }
};
