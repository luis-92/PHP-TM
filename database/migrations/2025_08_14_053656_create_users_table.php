<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // nombre para mostrar
            $table->string('email')->unique();         // login por email
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');                // hash bcrypt
            $table->rememberToken();                   // "recordarme" en login
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
