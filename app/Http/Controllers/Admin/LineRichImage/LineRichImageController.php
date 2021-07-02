<?php

namespace App\Http\Controllers\Admin\LineRichImage;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Lp;
use App\Models\LineRichImage;

class LineRichImageController extends Controller
{

  public function lp_list(Request $request, $campaign_id)
  {
    try {
      $list = Lp::where('campaign_id', $campaign_id)->with('line_rich_images')->get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    return response()->json(['lps' =>$list]);
  }

  public function lp_image_list(Request $request, $lp_id)
  {
    try {
      $list = LineRichImage::where('lp_id', $lp_id)->get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    return response()->json(['line_rich_images' =>$list]);
  }

  public function new(Request $request, $lp_id) {
    $input = $request->all();

    $validator = Validator::make($input, [
      'image' => 'required|file|image',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }
    // file upload
    $file = $request->file('image');
    $fname = time() . $file->getClientOriginalName();
    $file->storeAs('public/line-rich-images', $fname);
    $url = url('/storage/line-rich-images/'. $fname);

    try {
      $lri = LineRichImage::create([
        'lp_id' => $lp_id,
        'url' => $url
      ]);
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    return response()->json(['line_rich_image' => $lri]);
  }

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
}
