<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateLeadTrack extends Model
{
    protected $fillable = ['lp_id', 'affiliate_id'];

    public function lp() {
      return $this->belongsTo('App\Models\Lp');
    }

    public function affiliate() {
      return $this->belongsTo('App\Models\Affiliate');
    }
}
