<?php

namespace App\Http\Controllers\Admin\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Affiliate;
use App\Models\Rank;
use App\Models\AffiliateTeam;

class AffiliateController extends Controller
{
  public function list(Request $request)
  {
    $search = $request->get('search', '');
    $order = $request->get('order', 'id'); // id, date, rank
    try {
      $lists = Affiliate::with('rank');
      if($search !== '') {
        $lists = $lists->where('name_first', 'like', "%$search%")
          ->orWhere('name_last', 'like', "%$search%");
      }
      if($order === 'date') {
        $lists = $lists->orderBy('created_at');
      }
      if($order === 'rank') {
        $lists = $lists->orderBy('rank_id');
      }
      $lists = $lists->get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    $ranks = Rank::get();
    return response()->json(['affiliates' =>$lists, 'ranks' => $ranks]);
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
      'nickname' => 'required',
      'rank_id' => 'required',
      'note' => 'nullable'
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }

    $cat = Affiliate::create($input);
    $list = Affiliate::with('rank')->get();

    return response()->json(['errors' => [], 'affiliates' => $list]);
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
      Affiliate::whereIn('id', $ids)->delete();
    } catch(\Exception $e) {
      return response()->json(['error' => 'not delete'], 400);
    }
    return response()->json(['error' => '']);
  }
}
