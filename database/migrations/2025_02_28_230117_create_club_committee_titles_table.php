<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('club_committee_titles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('club_id')->constrained()->onDelete('cascade');
            $table->enum('committee_title', [
                'president',
                'assembly_officer',
                'secretary',
                'vp_education',
                'vp_membership',
                'treasurer',
                'member'
            ])->default('member');
            $table->date('start_date')->default(Carbon::now());
            $table->date('end_date')->default(Carbon::now()->addYear());
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('club_committee_titles');
    }
};
