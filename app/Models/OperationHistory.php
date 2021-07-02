<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationHistory extends Model
{
    protected $fillable = ['manager_id','campaign_id','memo'];

    public function campaign() {
        return $this->hasOne('App\Models\Campaign');
    }

    public function manager() {
        return $this->hasOne('App\Models\Manager');
    }
}
