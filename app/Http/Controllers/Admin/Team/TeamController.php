<?php

namespace App\Http\Controllers\Admin\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Affiliate;
use App\Models\AffiliateTeam;
use App\Models\Team;
use App\Models\Campaign;

class TeamController extends Controller
{
  public function list(Request $request)
  {
    try {
      $lists = Team::get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    $campaigns = Campaign::get();
    $affiliates = Affiliate::get();
    return response()->json(['teams' =>$lists, 'campaigns' => $campaigns, 'affiliates' => $affiliates]);
  }

  public function new(Request $request) {
    $input = $request->all();

    $validator = Validator::make($input, [
      'name' => 'required',
      'campaign_id' => 'nullable',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }

    $cat = Team::create($input);
    $list = Team::get();

    return response()->json(['errors' => [], 'teams' => $list]);
  }

  public function edit(Request $request) {

  }

  public function get(Request $request, $id) {
    if(!isset($id)) {
      return response()->json(['error' => 'wrong id'], 400);
    }
    $affiliate = Affiliate::with('rank')->find($id);
    return response()->json(['affiliate' => $affiliate]);
  }

  public function delete(Request $request) {
    $sIds = $request->get('ids', '');
    $ids = explode(',', $sIds);
    try {
      Team::whereIn('id', $ids)->delete();
    } catch(\Exception $e) {
      return response()->json(['error' => 'not delete'], 400);
    }

    $list = Team::get();
    return response()->json(['errors' => [], 'teams' => $list]);
  }

  public function addMember(Request $request) {
    $input = $request->all();

    $validator = Validator::make($input, [
      'team_id' => 'required',
      'affiliate_id' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }

    $cat = AffiliateTeam::create($input);
    $list = Team::get();

    return response()->json(['errors' => [], 'teams' => $list]);

  }
}
