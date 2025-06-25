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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name');
            $table->string('first_last_name');
            $table->string('second_last_name')->nullable();
            $table->date('join_date');
            // true: user is active | false: user is inactive 
            $table->boolean('active');
            $table->string('level')->nullable();
            $table->string('phone_number')->nullable()->unique();
            $table->string('gender')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('occupation')->nullable();
            $table->string('social_media_instagram')->nullable();
            $table->string('social_media_fb')->nullable();
            $table->string('social_media_tiktok')->nullable();
            $table->string('achievements_interest')->nullable();
            $table->text('professional_goals')->nullable();
            $table->string('mentor_name')->nullable();
            $table->boolean('is_mentor')->nullable();
            $table->string('mentee_name')->nullable();
            $table->string('user_type')->nullable();
            $table->text('expected_objectives')->nullable();
            $table->text('is_required_speak_job')->nullable();
            $table->text('actual_level_speech')->nullable();
            $table->text('actual_leadership_skills')->nullable();
            $table->text('concerns_public_speak')->nullable();
            $table->text('concerns_leadership')->nullable();
            $table->text('why_join_toastmasters')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
