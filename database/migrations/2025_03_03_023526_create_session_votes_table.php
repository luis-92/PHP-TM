<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('session_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('toastmasters_sessions')->onDelete('cascade');
            $table->foreignId('voter_id')->constrained('members')->onDelete('cascade');
            $table->foreignId('candidate_id')->constrained('members')->onDelete('cascade');
            $table->string('category');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_votes');
    }
};
