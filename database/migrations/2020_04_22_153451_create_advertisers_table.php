<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_last');
            $table->string('name_first');
            $table->string('furi_last');
            $table->string('furi_first');
            $table->string('email');
            $table->string('password');
            $table->tinyInteger('rank_id');
            $table->string('company');
            $table->string('company_furi');
            $table->string('zipcode');
            $table->string('address');
            $table->string('phone');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisers');
    }
}
