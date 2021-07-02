<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = ['campaign_id', 'link'];

    public function campaign() {
      return $this->belongsTo('App\Models\Campaign');
    }
}
