<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('furi_first_name');
            $table->string('furi_last_name');
            $table->string('nick_name');
            $table->string('gender')->default('none')->comment('gender of user: male, female, none');
            $table->date('dob')->nullable();
            $table->string('site')->nullable();
            $table->string('avatar')->nullable();
            $table->tinyInteger('mailmaga')->default(0)->comment('setting of mailmaga receipt');
            $table->tinyInteger('contract_notify')->default(0)->comment('setting of contract notification receipt');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
