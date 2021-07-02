<?php

namespace App\Http\Controllers\Admin\LineAccount;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Lp;
use App\Models\LineAccount;

class LineAccountController extends Controller
{
  public function save(Request $request) {
    $url = $request->get('image_url');
    if($request->hasFile('image')) {
      $file = $request->file('image');
      $fname = time() . $file->getClientOriginalName();
      $file->storeAs('public/line-accounts', $fname);
      $url = url('/storage/line-accounts/'. $fname);
    }
    $input = $request->except(['image']);

    $validator = Validator::make($input, [
      'id' => 'required',
      'campaign_id' => 'required',
      'channel_url' => 'required|url',
      'channel_secret' => 'required',
      'access_token' => 'required',
      'redirect_url' => 'required|url',
      'image_url' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }
    $input['image_url'] = $url;

    try {
      if($input['id'] !== 0) {
        $la = LineAccount::create($input);
        $id = $la->id;
      } else {
        $id = $input['id'];
        LineAccount::where('id', $input['id'])->update($request->except(['image', 'id']));
      }
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    return response()->json(['account' => LineAccount::find($id)]);
  }

  public function get(Request $request, $campaign_id) {
    try {
      $account = LineAccount::where('campaign_id', $campaign_id)->first();
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    return response()->json(['account' => $account]);
  }
/*
  public function delete(Request $request, $id) {
    try {
      $lri = LineRichImage::find($id);
      $lp_id = $lri->lp_id;
      $lri->delete();
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    $images = LineRichImage::where('lp_id', $lp_id)->get();
    return response()->json(['images' => $images]);
  }
*/
}
