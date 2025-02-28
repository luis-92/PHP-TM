<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('session_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('toastmasters_sessions')->onDelete('cascade');
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['grammarian', 'timer', 'ah-counter', 'general_evaluator']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_roles');
    }
};
