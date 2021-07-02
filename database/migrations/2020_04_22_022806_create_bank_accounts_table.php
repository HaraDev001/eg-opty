<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment('id of users table');
            $table->tinyInteger('bank_type')->default('0')->comment('国内: 0, 国外:1');
            $table->string('bank_name')->comment('銀行名');
            $table->string('bank_code')->comment('銀行番号');
            $table->string('branch_name')->comment('支店名');
            $table->string('branch_code')->comment('支店番号');
            $table->tinyInteger('account_type')->comment('普通預金:0,定期預金:1,積立型預金:3');
            $table->string('account_number')->comment('口座番号');
            $table->string('account_holder')->comment('口座名義');

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
        Schema::dropIfExists('bank_accounts');
    }
}
