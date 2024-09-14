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
        Schema::create('cards', function (Blueprint $table) {
	        $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained();
            $table->string('bank_name', 255)->nullable();
            $table->string('account_number', 255)->nullable();
            $table->string('card_number', 16)->nullable();
            $table->string('iban', 26)->nullable();
            $table->string('owner', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
