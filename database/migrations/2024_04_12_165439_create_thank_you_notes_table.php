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
        Schema::create('thank_you_notes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->index();
            $table->enum('type', ['text', 'video', 'voice'])->default('text');
            $table->string('subject');
            $table->longText('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thank_you_notes');
    }
};
