<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
  public const STATUS_ACTIVE = 1;
  public const STATUS_INACTIVE = 0;

  /**
   * The attributes that are mass assignable.
   * @var array
   */
  protected $fillable = [
    'name_first', 'name_last', 'furi_first', 'furi_last', 'email', 'password', 'nickname', 'rank_id', 'note', 'status'
  ];

  protected $appends = ['status_label', 'name_full', 'special_reward_amount', 'rank_name'];

  public function rank() {
    return $this->belongsTo('App\Models\Rank');
  }

  public function special_rewards() {
    return $this->hasMany('App\Models\SpecialReward');
  }

  public function lead_extend_affiliates() {
    return $this->hasMany('App\Models\LeadExtendAffiliate');
  }

  public function getStatusOptions() {
    return [
      static::STATUS_ACTIVE => '確認済み',
      static::STATUS_INACTIVE => '登録済み'
    ];
  }

  public function getSpecialRewardAmountAttribute() {
    $srs = $this->special_rewards;
    $sum = 0;
    foreach ($srs as $sr) {
      $sum += $sr->amount;
    }
    return $sum;
  }

  public function getRankNameAttribute() {
    return $this->rank ? $this->rank->name : '';
  }

  public function getStatusLabelAttribute()
  {
    return $this->getStatusOptions()[$this->status];
  }

  public function getNameFullAttribute()
  {
    return $this->name_last .' '. $this->name_first;
  }

  public function teams() {
    return $this->belongsToMany('App\Models\Team', 'affiliate_team');
  }

  public function contacts() {
    return $this->hasMany('App\Models\Contact');
  }
}
