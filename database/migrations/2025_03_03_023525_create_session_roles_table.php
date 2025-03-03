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
            $table->enum('role', [
                'grammarian',
                'timer',
                'ah-counter',
                'general_evaluator',
                'speech_evaluator'
            ]);
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('set null'); // Miembro titular
            $table->foreignId('substitute_member_id')->nullable()->constrained('members')->onDelete('set null'); // Sustituto predefinido
            $table->foreignId('replacement_member_id')->nullable()->constrained('members')->onDelete('set null'); // Miembro que tomó el rol en tiempo real
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_roles');
    }
};
