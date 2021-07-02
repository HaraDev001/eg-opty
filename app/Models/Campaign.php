<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
  protected $fillable = [
    'advertiser_id', // 出稿広告主
    'title', // キャンペーン名
    'image', // アイキャッチ画像
    'date_start',
    'time_start',
    'date_end',     // キャンペーン期間
    'time_end',     // キャンペーン期間
    'youtube_url',  // Youtube予告URL
    'affiliate_pr',    // アフィリエイター向け PR文
    'notes',        // 注意事項
    'mail_redirect_url',    // 成約除外メアドリダイレクトURL
    'detail_pdf',   // 詳細PDF
    'opt_in_method',    // オプトイン方式
    'content_type', // コンテンツタイプ
    'company_show', // 会社名表示
    'always_posting',       // 常時掲載案件化
    'show_setting',  // 表示設定
    'campaign_summary',     // キャンペーン概要
    'deposit_amount',     // デポジット金額
    'contracts_limit',     // 成約上限数
    'remarks',      // 備考
    'register_number', // 登録数
    'expense', // 経費
    'block_number', // ブロック数
    'average_lp_register_rate', // 平均LP登録率
    'status',   // 0: draft, 1: post
  ];

  public function stories()
  {
    return $this->hasMany('App\Models\Story');
  }

  public function main_rewards()
  {
    return $this->hasMany('App\Models\MainReward');
  }

  public function special_rewards()
  {
    return $this->hasMany('App\Models\SpecialReward');
  }

  public function first_come_rewards()
  {
    return $this->hasMany('App\Models\FirstComeReward');
  }

  public function increased_rewards()
  {
    return $this->hasMany('App\Models\IncreasedReward');
  }

  public function lps()
  {
    return $this->hasMany('App\Models\Lp');
  }

  public function advertiser() {
    return $this->belongsTo('App\Models\Advertiser');
  }

  public function line_account() {
    return $this->hasOne('App\Models\LineAccount');
  }

  public function lead_extend_affiliates() {
    return $this->hasMany('App\Models\LeadExtendAffiliate');
  }

  public function rank_excepts() {
    return $this->hasMany('App\Models\RankExcept');
  }
}
