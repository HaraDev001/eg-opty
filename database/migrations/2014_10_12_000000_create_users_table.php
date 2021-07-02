<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('user')->comment('value: admin, user');
            $table->string('name_first');
            $table->string('name_last');
            $table->string('furi_first');
            $table->string('furi_last');
            $table->string('nick_name');
            $table->string('avatar');
            $table->tinyInteger('gender')->default(0)->comment('undefined:0,man:1,woman:2');
            $table->date('dob')->nullable();
            $table->string('website')->nullable();
            $table->tinyInteger('mailmaga')->default(0)->comment('1:receive, 0:other');
            $table->tinyInteger('contract_alert')->default(0)->comment('1:receive, 0:other');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
