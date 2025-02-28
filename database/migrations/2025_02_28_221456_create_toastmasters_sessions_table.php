<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('toastmasters_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained()->onDelete('cascade');
            $table->dateTime('session_date');
            $table->text('agenda');
            $table->text('notes')->nullable();
            $table->enum('status', ['planned', 'in_progress', 'completed'])->default('planned');
            $table->integer('duration')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('toastmasters_sessions');
    }
};
