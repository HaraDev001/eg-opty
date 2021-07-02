<?php

namespace App\Http\Controllers\Admin\FirstCome;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\FirstComeReward;
use App\Models\Rank;
use App\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FirstComeRewardController extends Controller
{
  public function list(Request $request, $campaign_id)
  {
    try {
      $list = FirstComeReward::with('rank')
        ->with('campaign')
        ->with('affiliate')
        ->where('campaign_id', $campaign_id)->get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    $ranks = Rank::get();
    $affiliates = Affiliate::get();
    return response()->json(['rewards' =>$list, 'ranks' => $ranks, 'affiliates' => $affiliates]);
  }

  public function new(Request $request) {
    $input = $request->all();

    $validator = Validator::make($input, [
      'id' => 'required',
      'campaign_id' => 'required',
      'rank_id' => 'required',
      'affiliate_id' => 'required',
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
      FirstComeReward::create($input);
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    $list = FirstComeReward::with('rank')
      ->with('campaign')
      ->with('affiliate')
      ->where('campaign_id', $campaign_id)->get();
    return response()->json(['rewards' => $list]);
  }

  public function delete(Request $request, $id) {
    try {
      FirstComeReward::where('id', $id)->delete();
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    return response()->json(['errors' => []]);
  }

  public function bulk_edit(Request $request) {
    $input = $request->all();
    $validator = Validator::make($input, [
      'campaign_id' => 'required|integer',
      'date_start' => 'required|date',
      'time_start' => 'required',
      'date_end' => 'required|date',
      'time_end' => 'required',
      'amount' => 'required|integer',
      'is_show' => 'required',
      'ids' => 'required|array'
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }

    $data = $request->except(['ids']);
    try {
      FirstComeReward::whereIn('id', $input['ids'])->update($data);
    } catch(\Exception $e) {
      return response()->json(['errors' => [$e->getMessage()]], 400);
    }
    $list = FirstComeReward::with('rank')
      ->with('campaign')
      ->with('affiliate')
      ->where('campaign_id', $input['campaign_id'])->get();

    return response()->json(['rewards' => $list]);
  }
}
