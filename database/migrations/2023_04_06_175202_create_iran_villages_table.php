<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIranVillagesTable extends Migration
{
    /**
     * Migration for abadi
     *
     * Run the migrations.
     *
     * This table is equal to abadi in farsi
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iran_villages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('type')
                ->comment('0 means a typical village.  1 means industrial zone, a small group of buildings, facilities, factories and so on');
            $table->unsignedInteger('diag')->nullable();
            $table->string('code', 50)->unique();
            $table->string('short_code', 20);
            $table->boolean('status')->default(1);

            $table->foreignId('province_id')->constrained('iran_provinces')->onDelete('cascade');
            $table->foreignId('county_id')->constrained('iran_counties')->onDelete('cascade');
            $table->foreignId('sector_id')->constrained('iran_sectors')->onDelete('cascade');
            $table->foreignId('rural_district_id')->constrained('iran_rural_districts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iran_villages');
    }
}
