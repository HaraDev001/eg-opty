<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LpReward extends Model
{
    protected $fillable = ['lp_id', 'amount', 'rank_id', 'date_start', 'time_start', 'date_end', 'time_end'];
    protected $appends = ['rank_name'];

    public function lp() {
      return $this->belongsTo('App\Models\Lp');
    }

    public function rank() {
      return $this->belongsTo('App\Models\Rank');
    }

    public function getRankNameAttribute() {
      return $this->rank->name;
    }
}
