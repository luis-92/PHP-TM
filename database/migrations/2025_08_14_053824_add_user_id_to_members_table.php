<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()
                ->constrained('users')->nullOnDelete();

            // Opcional: evita que el mismo user se duplique en el mismo club
            $table->unique(['user_id', 'club_id']);
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'club_id']);
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
