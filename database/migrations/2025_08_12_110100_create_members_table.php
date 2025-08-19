<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('members', function (Blueprint $t) {
            $t->id();
            $t->foreignId('club_id')->constrained('clubs')->cascadeOnDelete();
            $t->string('name');
            $t->string('first_lastname')->nullable();
            $t->string('second_lastname')->nullable();
            $t->date('join_date')->nullable();
            $t->boolean('member_status')->default(true);
            $t->string('member_level')->nullable();
            $t->string('phone_number')->nullable();
            $t->string('gender')->nullable();
            $t->string('email')->nullable();
            $t->string('address')->nullable();
            $t->string('city')->nullable();
            $t->string('state')->nullable();
            $t->string('country')->nullable();
            $t->string('emergency_contact_name')->nullable();
            $t->string('emergency_contact_phone')->nullable();
            $t->string('professional_goals')->nullable();
            $t->timestamps();
            $t->index(['club_id','member_status']);

        });
    }
    public function down(): void { Schema::dropIfExists('members'); }
};
