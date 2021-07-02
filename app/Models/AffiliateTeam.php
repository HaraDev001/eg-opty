<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateTeam extends Model
{
    protected $table = 'affiliate_team';
    protected $fillable =['team_id', 'affiliate_id'];
}
