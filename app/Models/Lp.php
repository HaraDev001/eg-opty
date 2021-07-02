<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lp extends Model
{
  protected $table = 'lps';
  protected $fillable = ['campaign_id', 'title', 'url', 'banner', 'is_public', 'redirect_url_pc', 'redirect_url_mobile', 'show_type', 'status'];

  protected $appends = ['show_type_label', 'public_label'];

  public function campaign()
  {
    return $this->belongsTo('App\Models\Campaign');
  }

  public function line_rich_images() {
    return $this->hasMany('App\Models\LineRichImage');
  }

  public function introductions() {
    return $this->hasMany('App\Models\MailLineIntroduction');
  }

  public function lp_rewards()
  {
    return $this->hasMany('App\Models\LpReward');
  }

  public function getShowTypeLabelAttribute()
  {
    $label = '非公開';
    if ($this->show_type === 1) $label = 'バナー表示';
    if ($this->show_type === 1) $label = 'タイトル';
    return $label;
  }

  public function getPublicLabelAttribute()
  {
    return $this->is_public === 0 ? '非公開' : '公開';
  }

  public function registered_mails() {
    return $this->hasMany('App\Models\RegisteredMail');
  }

  public function registered_lines() {
    return $this->hasMany('App\Models\RegisteredLine');
  }
}
