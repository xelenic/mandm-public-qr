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
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Spa Ceylon Gift Voucher" or "Shagila Dinner Voucher"
            $table->text('description')->nullable();
            $table->string('type'); // e.g., "voucher", "dinner"
            $table->decimal('value', 10, 2)->nullable(); // monetary value if applicable
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gifts');
    }
};
