<?php

namespace App\Http\Controllers\Admin\Qa;

use App\Http\Controllers\Controller;
use App\Models\QuestionCategory;
use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Validator;

class QaController extends Controller
{

  public function list()
  {
    $lists = [];
    $categories = [];
    try {
      $lists = Question::with('category')->get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    try {
      $categories = QuestionCategory::get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    return response()->json(['questions' =>$lists, 'categories' => $categories]);
  }

  public function new(Request $request) {
    $input = $request->all();

    $validator = Validator::make($input, [
      'category_id' => 'required',
      'question' => 'required|unique:questions',
      'answer' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => 'question duplicated'], 400);
    }

    $cat = Question::create($input);
    $list = Question::with('category')->get();

    return response()->json(['errors' => [], 'questions' => $list]);
  }

  public function edit(Request $request) {

  }

  public function get(Request $request, $id) {
    if(!isset($id)) {
      return response()->json(['error' => 'wrong id'], 400);
    }
    $question = Question::with('category')->find($id);
    return response()->json(['question' => $question]);
  }

  public function delete(Request $request, $id) {
    if(!isset($id)) {
      return response()->json(['error' => 'wrong id'], 400);
    }
    try {
      Question::where('id', $id)->delete();
    } catch(\Exception $e) {
      return response()->json(['error' => 'not delete'], 400);
    }
    return response()->json(['error' => '']);
  }
}
