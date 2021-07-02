<?php

namespace App\Http\Controllers\Admin\LeadExtend;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\Campaign;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LeadExtendAffiliate;

class LeadExtendController extends Controller
{

  public function list(Request $request, $campaign_id)
  {
    try {
      $camp = Campaign::with('lead_extend_affiliates')->find($campaign_id);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    $affiliates = Affiliate::all();
    $teams = Team::all();
    return response()->json(['campaign' => $camp, 'affiliates' => $affiliates, 'teams' => $teams]);
  }

  public function save(Request $request)
  {
    $input = $request->all();

    $validator = Validator::make($input, [
      'campaign_id' => 'required',
      'affiliate_id' => 'nullable',
      'team_id' => 'nullable',
      'kind' => 'required',
      'date_start' => 'nullable',
      'time_start' => 'nullable',
      'date_end' => 'nullable',
      'time_end' => 'nullable',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }

    \DB::beginTransaction();
    try {
      if ($request->has('team_id')) {
        $affiliates = Team::find($request->get('team_id'))->members;
        foreach ($affiliates as $aff) {
          $data = $request->except(['team_id', 'search_type']);
          $data['affiliate_id'] = $aff->id;
          LeadExtendAffiliate::create($data);
        }
      } else {
        $data = $data = $request->except(['search_type']);
        LeadExtendAffiliate::create($data);
      }
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    \DB::commit();
    $camp = Campaign::with('lead_extend_affiliates')->find($request->get('campaign_id'));
    return response()->json(['campaign' => $camp]);
  }

  public function delete(Request $request, $id)
  {
    try {
      $lea = LeadExtendAffiliate::find($id);
      $campaign_id = $lea->campaign->id;
      $lea->delete();
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    $camp = Campaign::with('lead_extend_affiliates')->find($campaign_id);
    return response()->json(['campaign' => $camp]);
  }
}
