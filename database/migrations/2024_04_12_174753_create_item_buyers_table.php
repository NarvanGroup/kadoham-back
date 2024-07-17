<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_buyers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->index();
            $table->foreignUuid('item_id')->index();
            $table->json('buyers')->nullable();
            $table->longText('content')->nullable();
            $table->tinyInteger('is_public')->default(0);
            $table->unsignedSmallInteger('quantity')->nullable();
            $table->unsignedDecimal('amount', 11, 0)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_buyers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
