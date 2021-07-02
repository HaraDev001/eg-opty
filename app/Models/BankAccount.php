<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
  /**
   * The attributes that are mass assignable.
   * @var array
   */
  protected $fillable = [
    'user_id', 'bank_type', 'bank_name', 'bank_code',
    'branch_name', 'branch_code',
    'account_type', 'account_number', 'account_holder'
  ];

  public function user()
  {
    return $this->belongsTo('App\Models\User');
  }
}
