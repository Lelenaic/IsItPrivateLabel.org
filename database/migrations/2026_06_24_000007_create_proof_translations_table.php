<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proof_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proof_id')->constrained()->cascadeOnDelete();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->unique(['proof_id', 'language_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proof_translations');
    }
};
