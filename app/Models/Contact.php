<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
  /**
   * The attributes that are mass assignable.
   * @var array
   */
  protected $fillable = ['affiliate_id', 'advertiser_id', 'parent_id', 'title', 'content', 'kind', 'status'];

  public function affiliate()
  {
    return $this->belongsTo('App\Models\Affiliate');
  }

  public function advertiser()
  {
    return $this->belongsTo('App\Models\Advertiser');
  }

}
