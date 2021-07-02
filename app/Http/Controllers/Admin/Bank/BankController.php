<?php

namespace App\Http\Controllers\Admin\Bank;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class BankController extends BaseController
{

  public function new(Request $request) {
    $input = $request->all();

    $validator = Validator::make($request->all(), [
      'user_id' => 'required',
      'bank_type' => 'required',
      'bank_name' => 'required',
      'bank_code' => 'required',
      'branch_name' => 'required',
      'branch_code' => 'required',
      'account_type' => 'required',
      'account_number' => 'required',
      'account_holder' => 'required',
    ]);

    if ($validator->fails()) {
      $errors = $validator->errors();
      return response()->json(['errors' => $errors], 400);
    }

    $bank_account = BankAccount::create($input);

    return response()->json(['errors' => []]);
  }

}
