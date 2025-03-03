<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('experienced_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->unique()->constrained('members')->onDelete('cascade'); // Relación 1 a 1
            $table->integer('years_of_experience')->default(0); // Años de experiencia en Toastmasters
            $table->integer('speeches_given')->default(0); // Cantidad de discursos dados
            $table->integer('awards_won')->default(0); // Premios ganados (mejor orador, etc.)
            $table->text('certifications')->nullable(); // Certificaciones obtenidas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experienced_members');
    }
};
