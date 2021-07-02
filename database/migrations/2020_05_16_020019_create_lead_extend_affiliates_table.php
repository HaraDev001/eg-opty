<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadExtendAffiliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_extend_affiliates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('campaign_id')->comment('campaign id of campaigns table');
            $table->bigInteger('affiliate_id')->comment('id of affiliates table');
            $table->string('kind')->comment('lead or extend');
            $table->date('date_start')->nullable();
            $table->time('time_start')->nullable();
            $table->date('date_end')->nullable();
            $table->time('time_end')->nullable();
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
        Schema::dropIfExists('lead_extend_affiliates');
    }
}
