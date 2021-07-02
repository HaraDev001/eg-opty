<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FraudCandidate extends Model
{
    protected $fillable = ['affiliate_id','campaign_id','check_month','status','note'];

    public function affiliate() {
      return $this->belongsTo('App\Models\Affiliate');
    }

    public function campaign() {
      return $this->belongsTo('App\Models\Campaign');
    }
}
