<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineRichImage extends Model
{
    protected $table = 'line_rich_images';
    protected $fillable = ['lp_id', 'url'];

    public function Lp() {
      return $this->belongsTo('App\Models\Lp');
    }
}
