<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\QuestionCategory;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

  public function list()
  {
    try {
      $list = QuestionCategory::get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    return response()->json($list);
  }

  public function new(Request $request)
  {
    $input = $request->all();

    $validator = Validator::make($input, [
      'name' => 'required|unique:question_categories',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => 'category duplicated'], 400);
    }

    $cat = QuestionCategory::create($input);
    $list = QuestionCategory::get();

    return response()->json(['errors' => [], 'categories' => $list]);
  }

  public function edit(Request $request)
  {

  }

  public function get(Request $request)
  {

  }


  public function uploadImage(Request $request)
  {
    try {
      $path = $request->file('file')->store('avatars');
      return response()->json(['url' => $path]);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }
}
