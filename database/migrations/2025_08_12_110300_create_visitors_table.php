<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('visitors', function (Blueprint $t) {
            $t->id();
            $t->foreignId('club_session_id')->constrained('club_sessions')->cascadeOnDelete();
            $t->string('name');
            $t->string('email')->nullable();
            $t->string('phone')->nullable();
            $t->boolean('attended')->default(false);
            $t->text('comment')->nullable();
            $t->timestamps();

        });
    }
    public function down(): void { Schema::dropIfExists('visitors'); }
};
