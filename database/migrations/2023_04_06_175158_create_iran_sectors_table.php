<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIranSectorsTable extends Migration
{
    /**
     * Migration for bakhsh
     *
     * Run the migrations.
     *
     * This table is equal to bakhsh in farsi
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iran_sectors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 50)->unique();
            $table->string('short_code', 20);
            $table->boolean('status')->default(1);

            $table->foreignId('province_id')->constrained('iran_provinces')->onDelete('cascade');
            $table->foreignId('county_id')->constrained('iran_counties')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iran_sectors');
    }
}
