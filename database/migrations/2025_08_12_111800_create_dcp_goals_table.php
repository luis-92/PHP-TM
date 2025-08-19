<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dcp_goals', function (Blueprint $t) {
            $t->id();
            $t->string('code');
            $t->string('name');
            $t->text('description')->nullable();
            $t->timestamps();
            $t->unique('code');

        });
    }
    public function down(): void { Schema::dropIfExists('dcp_goals'); }
};
