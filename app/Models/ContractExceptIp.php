<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractExceptIp extends Model
{
    protected $fillable = ['campaign_id', 'ip'];

    public function campaign() {
        return $this->belongsTo('App\Models\Campaign');
    }
}
