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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->nullable()->constrained('users');
            $table->foreignId('sender_account_id')->nullable()->constrained('accounts');
            $table->foreignId('recipient_id')->nullable()->constrained('users');
            $table->foreignId('recipient_account_id')->nullable()->constrained('accounts');
            $table->string('reference')->index('tranfer_reference_index')->nullable();
            $table->string('status');
            $table->decimal('amount',16,4)->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
