<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainReward extends Model
{
    protected $fillable = [
      'campaign_id', 'rank_id', 'date_start', 'time_start', 'date_end', 'time_end', 'amount', 'is_show'
    ];

    public function campaign() {
      return $this->belongsTo('App\Models\Campaign');
    }

    public function rank() {
      return $this->belongsTo('App\Models\Rank');
    }
}
