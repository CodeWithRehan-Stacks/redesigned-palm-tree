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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_verified')->default(false)->after('role');
            $table->timestamp('last_active_at')->nullable()->after('updated_at');
            $table->unsignedInteger('followers_count')->default(0)->after('is_verified');
            $table->unsignedInteger('following_count')->default(0)->after('followers_count');
            $table->unsignedInteger('notes_count')->default(0)->after('following_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
