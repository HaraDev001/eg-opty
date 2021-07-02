<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('advertiser_id')->nullable()->comment('advertiser id');
            $table->bigInteger('affiliate_id')->nullable()->comment('affiliate id');
            $table->bigInteger('parent_id')->nullable()->comment('id of parent message');
            $table->string('title');
            $table->string('content', 1024);
            $table->string('kind')->default('advertiser')->comment('advertiser, affiliate');
            $table->tinyInteger('status')->default(0)->comment('0:新規,1:返信済,2:リプライ,3;完了');
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
        Schema::dropIfExists('contacts');
    }
}
