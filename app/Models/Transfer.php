<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = ['affiliate_id','amount','generate_at','pay_at','status','note'];

    public function affiliate() {
        return $this->belongsTo('App\Models\Affiliate');
    }
}
