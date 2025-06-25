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
        Schema::create('objectivesdcps', function (Blueprint $table) {
            $table->id();
            
            $table->date('tm_year'); 
            $table->string('objective_type'); 
            //?: Unique identifier? 
            $table->integer('dcp_value'); 
            $table->string('objective_name');
            $table->string('objective_category'); 
            $table->string('objective_progress');
            $table->string('relation_activity');
            $table->string('description');
            $table->string('compliment');
            $table->date('achievement_date');
            $table->string('note'); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objectivesdcps');
    }
};
