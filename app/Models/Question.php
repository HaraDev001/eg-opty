<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
  /**
   * The attributes that are mass assignable.
   * @var array
   */
  protected $fillable = [
    'category_id', 'question', 'answer'
  ];

  public function category()
  {
    return $this->belongsTo('App\Models\QuestionCategory');
  }
}
