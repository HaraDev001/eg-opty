<?php

namespace App\Http\Controllers\Admin\ContractExceptIp;

use App\Http\Controllers\Controller;
use App\Models\ContractExceptIp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContractExceptIpController extends Controller
{
  public function list(Request $request, $campaign_id)
  {
    try {
      $list = ContractExceptIp::where('campaign_id', $campaign_id)->get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    return response()->json(['ips' =>$list]);
  }

  public function new(Request $request) {
    $input = $request->all();

    $validator = Validator::make($input, [
      'campaign_id' => 'required',
      'ip' => 'required|ipv4',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }

    try {
      ContractExceptIp::create($input);
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    $list = ContractExceptIp::where('campaign_id', $input['campaign_id'])->get();
    return response()->json(['ips' => $list]);
  }

  public function delete(Request $request, $id) {
    try {
      $cei = ContractExceptIp::find($id);
      $campaign_id = $cei->campaign_id;
      $cei->delete();
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    $list = ContractExceptIp::where('campaign_id', $campaign_id)->get();
    return response()->json(['ips' => $list]);
  }
}
