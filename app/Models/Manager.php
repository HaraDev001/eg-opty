<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
  private const PERMISSION_LABELS = ['管理者', 'super管理者'];
  private const STATUS_LABELS = ['登録済み', '完了済み'];

  protected $fillable = ['name_last', 'name_first', 'email', 'password', 'permission'];
  protected $appends = ['name_full', 'status_label', 'permission_label'];

  public function getNameFullAttribute()
  {
    return $this->name_last . $this->name_first;
  }

  public function getStatusLabelAttribute()
  {
    return self::STATUS_LABELS[$this->status];
  }

  public function getPermissionLabelAttribute()
  {
    return self::PERMISSION_LABELS[$this->permission];
  }
}
