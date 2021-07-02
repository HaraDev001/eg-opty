<?php

namespace App\Http\Controllers\Admin\Account;

use App\Components\Core\ResponseHelpers;
use App\Models\BankAccount;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ResponseHelpers;

  public function list()
  {
    try {
      $users = User::where('role', 'user')->get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    return response()->json($users);
  }

  public function new(Request $request) {
      $file = $request->file('avatar');
      $fname = time() . $file->getClientOriginalName();
      $file->storeAs('public/avatars', $fname);
      $url = url('/storage/avatars/'. $fname);

      $validator = Validator::make($request->all(), [
          'avatar' => 'required|file',
          'name_last' => 'required',
          'name_first' => 'required',
          'furi_last' => 'required',
          'furi_first' => 'required',
          'nick_name' => 'required|unique:users',
          'email' => 'required|unique:users',
      ]);

      if ($validator->fails()) {
          $errors = $validator->errors();
          return response()->json(['errors' => $errors], 400);
      }

      $input = $request->all();
      $input['name'] = $input['name_last'].$input['name_first'];
      $input['avatar'] = $url;
      $input['password'] = Hash::make('12345678');
      $user = User::create($input);

      return response()->json(['errors' => [], 'uid' => $user->id]);
  }

  public function edit(Request $request) {

  }

  public function get(Request $request) {

  }


  public function uploadImage(Request $request) {
    try {
      $path = $request->file('file')->store('avatars');
      return response()->json(['url' => $path]);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }
}
