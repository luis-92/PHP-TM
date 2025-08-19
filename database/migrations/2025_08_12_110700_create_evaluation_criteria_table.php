<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('evaluation_criteria', function (Blueprint $t) {
            $t->id();
            $t->foreignId('evaluation_type_id')->constrained('evaluation_types')->cascadeOnDelete();
            $t->string('name');
            $t->text('description')->nullable();
            $t->timestamps();

        });
    }
    public function down(): void { Schema::dropIfExists('evaluation_criteria'); }
};
