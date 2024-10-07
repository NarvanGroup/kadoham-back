<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Payment\App\Enums\Novinpal\IpgPortEnum;
use Modules\Payment\App\Enums\Novinpal\IpgStatusEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ipg_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users');
            $table->enum('port', IpgPortEnum::values())->default(IpgPortEnum::NOVINPAL);
            $table->unsignedBigInteger('amount');
            $table->string('order_id', 100)->unique()->nullable();
            $table->string('ref_number', 100)->unique()->nullable();
            $table->string('ref_id', 100)->unique()->nullable();
            $table->string('card_number', 50)->nullable();
            $table->string('mobile', 50)->nullable();
            $table->enum('status', IpgStatusEnum::values())->default(IpgStatusEnum::TRANSACTION_INIT);
            $table->string('ip', 20)->nullable();
            $table->string('error_code')->nullable();
            $table->string('error_description')->nullable();
            $table->text('description')->nullable();
            $table->json('meta')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('failed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipg_transactions');
    }
};
