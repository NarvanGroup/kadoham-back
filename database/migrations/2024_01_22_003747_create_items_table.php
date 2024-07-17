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
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->index();
            $table->enum('type',['product','cash','experience','diy','charity'])->default('product')->index();
            $table->unsignedDecimal('price',11,0)->nullable();
            $table->longText('link')->nullable();
            $table->unsignedBigInteger('quantity')->default(1);
            $table->string('image',4096)->nullable();
            $table->string('where_to_buy')->nullable();
            $table->unsignedInteger('rate')->nullable();
            $table->longText('description')->nullable();
            #Experiance
            $table->json('category')->nullable();
            #Cash
            $table->unsignedDecimal('amount', 11,0)->nullable();
            #Charity
            $table->json('charity')->nullable();
            $table->enum('visibility',['public','protected','private'])->default('public')->index();
            $table->enum('status',['pending','reserved','completed'])->default('pending')->index();
            $table->foreignUuid('wish_list_id')->constrained('wish_lists')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['name','wish_list_id', 'user_id']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
