<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisteredMail extends Model
{
  protected $fillable = ['lp_id', 'customer_email', 'customer_name'];

  public function lp()
  {
    return $this->belongsTo('App\Models\Lp');
  }
}
