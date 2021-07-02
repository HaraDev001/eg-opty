<?php

namespace App\Http\Controllers\Admin\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Manager;

class ManagerController extends Controller
{
  public function list(Request $request)
  {
    try {
      $lists = Manager::get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    return response()->json(['managers' =>$lists]);
  }

  public function new(Request $request) {
    $input = $request->all();

    $validator = Validator::make($input, [
      'name_last' => 'required',
      'name_first' => 'required',
      'email' => 'email:rfc|required|unique:managers',
      'password' => 'required|min:8|confirmed',
      'permission' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }

    $cat = Manager::create($input);
    $list = Manager::get();

    return response()->json(['managers' => $list]);
  }

  public function edit(Request $request) {

  }

  public function get(Request $request, $id) {
    if(!isset($id)) {
      return response()->json(['error' => 'wrong id'], 400);
    }
    $manager = Manager::find($id);
    return response()->json(['manager' => $manager]);
  }

  public function delete(Request $request, $id) {
    try {
      Manager::where('id', $id)->delete();
    } catch(\Exception $e) {
      return response()->json(['error' => 'not delete'], 400);
    }
    $list = Manager::get();

    return response()->json(['managers' => $list]);
  }
}
