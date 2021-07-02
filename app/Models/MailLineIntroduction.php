<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailLineIntroduction extends Model
{
    protected $fillable = ['lp_id', 'title', 'content', 'target'];

    public function lp() {
      return $this->belongsTo('App\Models\Lp');
    }
}
