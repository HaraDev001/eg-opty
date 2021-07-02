<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisteredLine extends Model
{
  protected $fillable = ['lp_id', 'customer_name', 'customer_line_id'];

  public function lp() {
    return $this->belongsTo('App\Models\Lp');
  }
}
