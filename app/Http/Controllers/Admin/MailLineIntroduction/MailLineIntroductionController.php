<?php

namespace App\Http\Controllers\Admin\MailLineIntroduction;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Lp;
use App\Models\MailLineIntroduction;

class MailLineIntroductionController extends Controller
{

  public function lp_list(Request $request, $campaign_id)
  {
    try {
      $list = Lp::where('campaign_id', $campaign_id)->with('introductions')->get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    return response()->json(['lps' =>$list]);
  }

  public function new(Request $request, $lp_id) {
    $input = $request->all();

    $validator = Validator::make($input, [
      'title' => 'required',
      'content' => 'required'
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }
    $input['lp_id'] = $lp_id;
    try {
      MailLineIntroduction::create($input);
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    $lp = Lp::with('introductions')->find($lp_id);
    return response()->json(['lp' => $lp]);
  }

  public function delete(Request $request, $id) {
    try {
      $mli = MailLineIntroduction::find($id);
      $lp_id = $mli->lp_id;
      $mli->delete();
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    $introductions = MailLineIntroduction::where('lp_id', $lp_id)->get();
    return response()->json(['introductions' => $introductions]);
  }
}
