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
        Schema::create('developments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('thumbnail');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('person_in_charge');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('amount');
            $table->enum('status', ['completed', 'ongoing'])->default('ongoing');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('developments');
    }
};
