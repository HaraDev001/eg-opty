<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RankExcept extends Model
{
  protected $fillable = ['campaign_id', 'affiliate_id'];
  protected $appends = ['affiliate_name', 'rank_name'];

  public function campaign()
  {
    return $this->belongsTo('App\Models\Campaign');
  }

  public function affiliate()
  {
    return $this->belongsTo('App\Models\Affiliate');
  }

  public function getAffiliateNameAttribute()
  {
    return $this->affiliate->name_full;
  }

  public function getRankNameAttribute()
  {
    return $this->affiliate->rank->name;
  }
}
