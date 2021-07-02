<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('campaign_id');
            $table->string('title');
            $table->string('url', 1024);
            $table->string('banner');
            $table->tinyInteger('is_public');
            $table->string('redirect_url_pc', 1024);
            $table->string('redirect_url_mobile', 1024);
            $table->tinyInteger('show_type')->nullable()->comment('非公開:0,バナー表示:1,タイトル:2');
            $table->tinyInteger('status')->default(0)->comment('0:draft, 1:complete');
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
        Schema::dropIfExists('lps');
    }
}
