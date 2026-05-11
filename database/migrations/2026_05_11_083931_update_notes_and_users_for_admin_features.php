<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'university_id')) {
                $table->foreignId('university_id')->nullable()->constrained()->onDelete('set null');
            }
            if (!Schema::hasColumn('users', 'earnings')) {
                $table->decimal('earnings', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('users', 'subscription_status')) {
                $table->string('subscription_status')->default('free');
            }
            if (!Schema::hasColumn('users', 'subscription_expires_at')) {
                $table->timestamp('subscription_expires_at')->nullable();
            }
        });

        Schema::table('notes', function (Blueprint $table) {
            if (!Schema::hasColumn('notes', 'university_id')) {
                $table->foreignId('university_id')->nullable()->constrained()->onDelete('set null');
            }
            if (!Schema::hasColumn('notes', 'subject_id')) {
                $table->foreignId('subject_id')->nullable()->constrained()->onDelete('set null');
            }
            if (!Schema::hasColumn('notes', 'status')) {
                $table->string('status')->default('pending'); // pending, approved, rejected
            }
            if (!Schema::hasColumn('notes', 'ai_score')) {
                $table->float('ai_score')->default(0);
            }
            if (!Schema::hasColumn('notes', 'is_premium')) {
                $table->boolean('is_premium')->default(false);
            }
            if (!Schema::hasColumn('notes', 'downloads_count')) {
                $table->integer('downloads_count')->default(0);
            }
            if (!Schema::hasColumn('notes', 'moderator_notes')) {
                $table->text('moderator_notes')->nullable();
            }
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['university_id', 'earnings', 'is_verified', 'subscription_status', 'subscription_expires_at']);
        });
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn(['university_id', 'subject_id', 'status', 'ai_score', 'is_premium', 'downloads_count', 'moderator_notes']);
        });
    }
};
