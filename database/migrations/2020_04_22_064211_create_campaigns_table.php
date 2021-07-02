<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('campaigns', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('title')->comment('キャンペーン名');
      $table->bigInteger('advertiser_id')->comment('出稿広告主');
      $table->string('image')->comment('アイキャッチ画像');
      $table->date('date_start')->comment('キャンペーン期間');
      $table->time('time_start')->comment('キャンペーン期間');
      $table->date('date_end')->comment('キャンペーン期間');
      $table->time('time_end')->comment('キャンペーン期間');
      $table->string('youtube_url')->comment('Youtube予告URL');
      $table->string('affiliate_pr')->comment('アフィリエイター向け PR文');
      $table->string('notes')->comment('記載注意事項');
      $table->string('mail_redirect_url')->comment('リダイレクトURL');
      $table->string('detail_pdf')->nullable()->comment('詳細PDF');
      $table->tinyInteger('opt_in_method')->default(0)->comment('オプトイン方式');
      $table->tinyInteger('content_type')->default(0)->comment('コンテンツタイプ');
      $table->tinyInteger('company_show')->default(1)->comment('会社名表示設定 0:hide,1:show');
      $table->tinyInteger('always_posting')->default(1)->comment('常時掲載案件化 0:hide,1:show');
      $table->tinyInteger('show_setting')->default(1)->comment('表示設定 0:hide,1:show');
      $table->string('campaign_summary')->comment('キャンペーン概要');
      $table->string('remarks')->comment('備考');
      $table->integer('deposit_amount')->default(0)->comment('デポジット金額');
      $table->integer('contracts_limit')->default(0)->comment('成約上限数');
      $table->integer('register_number')->default(0)->comment('登録数');
      $table->integer('expense')->default(0)->comment('経費');
      $table->integer('block_number')->default(0)->comment('ブロック数');
      $table->float('average_lp_register_rate')->default(0)->comment('平均LP登録率');
      $table->tinyInteger('status')->default(0)->comment('0: draft, 1:post');
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
    Schema::dropIfExists('campaigns');
  }
}
