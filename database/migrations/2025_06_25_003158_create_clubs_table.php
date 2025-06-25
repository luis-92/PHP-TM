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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id(); // Primary key 
            $table->string('name');
            // ?: club_number, is not the same than having and Id? 
            $table->integer('club_number')->unique();
            $table->string('area'); 
            $table->string('division'); 
            $table->integer('district');
            $table->date('founding_date'); // Date format (YYYY-MM-DD)
            $table->string('location'); 
            $table->string('language'); 

            // ?: Schedule and meeting days, are not the same?
            // TODO: Needs another table to handle schedule
            $table->string('meeting_days');
            $table->string('schedule'); 
            // ?: -----------------------------------

            $table->string('modality_meeting');
            $table->string('zoom_link')->nullable(); // Text field (optional in case not always used)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
