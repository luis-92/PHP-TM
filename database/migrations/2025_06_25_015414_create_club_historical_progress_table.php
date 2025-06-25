<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('club_historical_progress', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('active_members');
            $table->integer('new_members');
            $table->decimal('retention_rate');
            $table->decimal('average_attendance'); 
            $table->integer('speeches_done');
            $table->integer('assessments_done');
            $table->integer('external_events')->nullable();
            $table->integer('contest_participation')->nullable();
            $table->integer('social_media_followers')->nullable();
            $table->string('distinctions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_historical_progress');
    }
};
