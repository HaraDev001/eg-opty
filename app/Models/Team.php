<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable =['name', 'campaign_id'];
    protected $appends = ['affiliate_names', 'campaign_name'];

    public function members() {
      return $this->belongsToMany('App\Models\Affiliate', 'affiliate_team');
    }

    public function campaign() {
      return $this->belongsTo('App\Models\Campaign');
    }

    public function getAffiliateNamesAttribute() {
      $affs = $this->members;
      $arr = [];
      foreach ($affs as $aff) {
        array_push($arr, $aff->name_full);
      }
      return implode(', ', $arr);
    }

    public function getCampaignNameAttribute() {
      $camp = $this->campaign;
      return is_null($camp) ? '' : $camp->title;
    }
}
