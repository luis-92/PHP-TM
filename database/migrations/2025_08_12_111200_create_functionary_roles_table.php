<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
         Schema::create('functionary_roles', function (Blueprint $t) {
            $t->id();
            $t->string('name');                 // p.ej. “Toastmaster of the Day”
            $t->unsignedTinyInteger('max_slots')->default(1); // Speakers/Evaluators pueden ser >1
            $t->string('code')->nullable();     // opcional: “TMOD”, “SPK”, “EVAL”
            $t->text('description')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('functionary_roles'); }
};
