<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailLineIntroductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_line_introductions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('lp_id');
            $table->string('title');
            $table->text('content');
            $table->string('target')->comment('flag for mail or line');
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
        Schema::dropIfExists('mail_line_introductions');
    }
}
