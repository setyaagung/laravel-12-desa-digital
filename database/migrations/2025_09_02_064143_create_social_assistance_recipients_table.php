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
        Schema::create('social_assistance_recipients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('social_assistance_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('head_of_family_id')->constrained()->cascadeOnDelete();
            $table->enum('bank', ['bri', 'bni', 'mandiri', 'bca']);
            $table->integer('account_number');
            $table->integer('amount');
            $table->text('reason')->nullable();
            $table->string('proof')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_assistance_recipients');
    }
};
