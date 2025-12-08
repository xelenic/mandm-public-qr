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
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // unique QR code identifier
            $table->foreignId('gift_id')->constrained()->onDelete('cascade');
            $table->boolean('is_scanned')->default(false);
            $table->timestamp('scanned_at')->nullable();
            $table->string('batch_number')->nullable(); // to track which M&M packet (1-200)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
    }
};
