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
        Schema::create('interests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('upper_body_size')->nullable();
            $table->string('lower_body_size')->nullable();
            $table->string('shoe_size')->nullable();
            $table->json('favorite_color')->nullable();
            $table->json('favorite_food')->nullable();
            $table->string('interests')->nullable();
            $table->string('personality')->nullable();
            $table->json('fashion_style')->nullable();
            $table->json('gift_type')->nullable();
            $table->longText('description')->nullable();
            $table->foreignUuid('user_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interests');
    }
};
