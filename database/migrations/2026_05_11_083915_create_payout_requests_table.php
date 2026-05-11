<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payout_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending'); // pending, approved, rejected, paid
            $table->text('admin_notes')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_details')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('payout_requests'); }
};
