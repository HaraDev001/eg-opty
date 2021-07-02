<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineAccount extends Model
{
    protected $fillable = ['campaign_id','channel_url','channel_secret','access_token','redirect_url','image_url'];

    public function campaign() {
      return $this->belongsTo('App\Models\Campaign');
    }
}
