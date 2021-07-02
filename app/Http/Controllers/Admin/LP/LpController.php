<?php

namespace App\Http\Controllers\Admin\Lp;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Lp;

class LpController extends Controller
{
  private function generateMailRegisterFormTag($lp_id) {
    return '<form action="'.url('/mail-register').'" method="get">' .
          '<input type="hidden" name="l" value="'.$lp_id.'"/>' .
          '<input type="text" name="n" required placeholder="名前"/>' .
          '<input type="email" name="e" required placeholder="電子メールアドレス"/>' .
          '<input type="submit" value="登録"/>' .
          '</form>';
  }

  private function generateLineRegisterTag($lp_id) {
    return '<form action="'.url('/line-register').'" method="get">' .
      '<input type="hidden" name="l" value="'.$lp_id.'"/>' .
      '<input type="text" name="n" required placeholder="名前"/>' .
      '<input type="text" name="u" required placeholder="ラインユーザーID"/>' .
      '<input type="submit" value="登録"/>' .
      '</form>';
  }

  private function generateAffiliateLink($lp_id) {
    return url('/affiliate-link?l='.$lp_id.'&a={affiliate_id}');
  }

  public function list(Request $request, $campaign_id)
  {
    try {
      $list = Lp::where('campaign_id', $campaign_id)->get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    return response()->json(['lps' =>$list]);
  }

  public function save(Request $request) {
    $input = $request->all();

    $validator = Validator::make($input, [
      'id' => 'required',
      'campaign_id' => 'required',
      'title' => 'required',
      'url' => 'required|url',
      'banner' => 'required|file|image', // |dimensions:width=800,height=200
      'is_public' => 'required',
      'redirect_url_pc' => 'required|url',
      'redirect_url_mobile' => 'required|url',
      'show_type' => 'required',
      'status' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }
    // banner save
    $file = $request->file('banner');
    $fname = time() . $file->getClientOriginalName();
    $file->storeAs('public/lp-banner', $fname);
    $url = url('/storage/lp-banner/'. $fname);
    $input['banner'] = $url;

    $id = $input['id'];
    unset($input['id']);

    try {
      if($id < 1) {
        Lp::create($input);
      } else {
        Lp::where('id', $id)->update($input);
      }
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    return response()->json(['errors' => []]);
  }

  public function delete(Request $request, $id) {
    try {
      Lp::where('id', $id)->delete();
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    return response()->json(['errors' => []]);
  }
}
