<?php

namespace App\Http\Controllers\Admin\RankExcept;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\Campaign;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\RankExcept;

class RankExceptController extends Controller
{

  public function list(Request $request, $campaign_id)
  {
    try {
      $camp = Campaign::with('rank_excepts')->find($campaign_id);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    $affiliates = Affiliate::all();
    $teams = Team::all();
    return response()->json(['campaign' => $camp, 'affiliates' => $affiliates, 'teams' => $teams]);
  }

  public function save(Request $request) {
    $input = $request->all();

    $validator = Validator::make($input, [
      'campaign_id' => 'required',
      'affiliate_id' => 'nullable',
      'team_id' => 'nullable',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }

    \DB::beginTransaction();
    try {
      if($request->has('team_id')) {
        $affiliates = Team::find($request->get('team_id'))->members;
        foreach ($affiliates as $aff) {
          $data = $request->except(['team_id', 'search_type']);
          $data['affiliate_id'] = $aff->id;
          RankExcept::create($data);
        }
      } else {
        $data = $data = $request->except(['search_type']);
        RankExcept::create($data);
      }
    } catch(\Exception $e) {
      \DB::rollBack();
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    \DB::commit();
    $campaign_id = $request->get('campaign_id');
    $list = RankExcept::with('affiliate')->where('campaign_id', $campaign_id)->get();
    return response()->json(['list' => $list]);
  }

  public function delete(Request $request, $id) {
    try {
      $lea = RankExcept::find($id);
      $campaign_id = $lea->campaign->id;
      $lea->delete();
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    $list = RankExcept::with('affiliate')->where('campaign_id', $campaign_id)->get();
    return response()->json(['list' => $list]);
  }
}
