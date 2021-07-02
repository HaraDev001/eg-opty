<?php

namespace App\Http\Controllers\Admin\Advertiser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Advertiser;
use App\Models\Rank;

class AdvertiserController extends Controller
{
  public function list(Request $request)
  {
    try {
      $lists = Advertiser::with('rank')->get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    $ranks = Rank::get();
    return response()->json(['advertisers' =>$lists, 'ranks' => $ranks]);
  }

  public function new(Request $request) {
    $input = $request->all();

    $validator = Validator::make($input, [
      'name_last' => 'required',
      'name_first' => 'required',
      'furi_last' => 'required',
      'furi_first' => 'required',
      'email' => 'email:rfc|required|unique:affiliates',
      'password' => 'required|min:8|confirmed',
      'rank_id' => 'required',
      'company' => 'required',
      'company_furi' => 'required',
      'zipcode' => 'required',
      'address' => 'required',
      'phone' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }

    $cat = Advertiser::create($input);
    $list = Advertiser::with('rank')->get();

    return response()->json(['advertisers' => $list]);
  }

  public function edit(Request $request) {

  }

  public function get(Request $request, $id) {
    if(!isset($id)) {
      return response()->json(['error' => 'wrong id'], 400);
    }
    $affiliate = Advertiser::with('rank')->find($id);
    return response()->json(['advertiser' => $affiliate]);
  }

  public function delete(Request $request, $id) {
    try {
      Advertiser::where('id', $id)->delete();
    } catch(\Exception $e) {
      return response()->json(['error' => 'not delete'], 400);
    }
    $list = Advertiser::with('rank')->get();

    return response()->json(['advertisers' => $list]);
  }
}
