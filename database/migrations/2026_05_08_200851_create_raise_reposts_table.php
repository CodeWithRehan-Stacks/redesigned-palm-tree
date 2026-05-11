<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raise_reposts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raise_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('content')->nullable(); // If it's a quote repost
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raise_reposts');
    }
};
