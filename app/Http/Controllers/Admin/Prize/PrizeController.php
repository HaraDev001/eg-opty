<?php

namespace App\Http\Controllers\Admin\Prize;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Prize;

class PrizeController extends Controller
{

  public function list(Request $request, $campaign_id)
  {
    try {
      $list = Prize::where('campaign_id', $campaign_id)
        ->orderBy('contract_rank')->get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    return response()->json(['prizes' =>$list]);
  }

  public function save(Request $request) {
    $input = $request->all();

    $validator = Validator::make($input, [
      'campaign_id' => 'required',
      'contract_rank' => 'required',
      'prize_name' => 'required',
      'image' => 'required|file|image', // |dimensions:width=800,height=200
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }
    // banner save
    $file = $request->file('image');
    $fname = time() . $file->getClientOriginalName();
    $file->storeAs('public/prize', $fname);
    $url = url('/storage/prize/'. $fname);
    $input['image'] = $url;

    unset($input['id']);

    try {
      Prize::create($input);
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    $list = Prize::where('campaign_id', $input['campaign_id'])
      ->orderBy('contract_rank')->get();
    return response()->json(['prizes' => $list]);
  }

  public function delete(Request $request, $id) {
    try {
      $prize = Prize::find($id);
      $campaign_id = $prize->campaign_id;
      $prize->delete();
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    $list = Prize::where('campaign_id', $campaign_id)
      ->orderBy('contract_rank')->get();
    return response()->json(['prizes' => $list]);
  }
}
