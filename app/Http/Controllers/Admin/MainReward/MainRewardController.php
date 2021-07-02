<?php

namespace App\Http\Controllers\Admin\MainReward;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\MainReward;
use App\Models\Rank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainRewardController extends Controller
{
  public function list(Request $request, $campaign_id)
  {
    try {
      $list = MainReward::with('rank')->with('campaign')->where('campaign_id', $campaign_id)->get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    $ranks = Rank::get();
    return response()->json(['rewards' =>$list, 'ranks' => $ranks]);
  }

  public function new(Request $request) {
    $input = $request->all();

    $validator = Validator::make($input, [
      'id' => 'required',
      'campaign_id' => 'required',
      'rank_id' => 'required',
      'date_start' => 'required|date',
      'time_start' => 'required',
      'date_end' => 'required|date',
      'time_end' => 'required',
      'amount' => 'required|integer',
      'is_show' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }
    unset($input['id']);
    $campaign_id = $input['campaign_id'];

    try {
      MainReward::create($input);
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    $list = MainReward::with('rank')->with('campaign')->where('campaign_id', $campaign_id)->get();
    return response()->json(['rewards' => $list]);
  }

  public function delete(Request $request, $id) {
    try {
      MainReward::where('id', $id)->delete();
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    return response()->json(['errors' => []]);
  }
}
