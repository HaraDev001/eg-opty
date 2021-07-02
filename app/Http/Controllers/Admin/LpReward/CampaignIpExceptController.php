<?php

namespace App\Http\Controllers\Admin\LpReward;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\LpReward;
use App\Models\Lp;
use App\Models\Rank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignIpExceptController extends Controller
{
  public function list(Request $request, $campaign_id)
  {
    try {
      $list = Lp::with('lp_rewards')->where('campaign_id', $campaign_id)->get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    $ranks = Rank::get();
    return response()->json(['lps' =>$list, 'ranks' => $ranks]);
  }

  public function save(Request $request) {
    $input = $request->all();

    $validator = Validator::make($input, [
      'id' => 'required',
      'lp_id' => 'required',
      'rank_id' => 'required',
      'date_start' => 'required|date',
      'time_start' => 'required',
      'date_end' => 'required|date',
      'time_end' => 'required',
      'amount' => 'required|integer',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }

    $campaign_id = $input['campaign_id'];
    $id = $input['id'];
    $data = $request->except(['id', 'campaign_id']);
    try {
      if($id === 0) {
        LpReward::create($data);
      } else {
        LpReward::where('id', $id)->update($data);
      }
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    $list = Lp::with('lp_rewards')->where('campaign_id', $campaign_id)->get();
    return response()->json(['lps' => $list]);
  }

  public function delete(Request $request, $id) {
    try {
      $lr = LpReward::find($id);
      $campaign = $lr->lp->campaign;
     $lr->delete();
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    $list = Lp::with('lp_rewards')->where('campaign_id', $campaign->id)->get();
    return response()->json(['lps' => $list]);
  }
}
