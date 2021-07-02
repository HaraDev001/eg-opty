<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertiser extends Model
{
  public const STATUS_ACTIVE = 1;
  public const STATUS_INACTIVE = 0;

  protected $fillable = [
    'name_last', 'name_first', 'furi_last', 'furi_first', 'email', 'password', 'rank_id',
    'company', 'company_furi', 'zipcode', 'address', 'phone', 'status'
  ];

  protected $appends = ['name_full', 'furi_full', 'rank_name', 'status_label'];

  public function getNameFullAttribute()
  {
    return $this->name_last . $this->name_first;
  }

  public function getFuriFullAttribute()
  {
    return $this->furi_last . $this->furi_first;
  }

  public function rank()
  {
    return $this->belongsTo('App\Models\Rank');
  }

  public function getRankNameAttribute()
  {
    return $this->rank->name;
  }

  public function getStatusOptions() {
    return [
      static::STATUS_ACTIVE => '確認済み',
      static::STATUS_INACTIVE => '登録済み'
    ];
  }

  public function getStatusLabelAttribute()
  {
    return $this->getStatusOptions()[$this->status];
  }

  public function contacts() {
    return $this->hasMany('App\Models\Contact');
  }

}
