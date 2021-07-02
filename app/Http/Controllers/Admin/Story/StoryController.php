<?php

namespace App\Http\Controllers\Admin\Story;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Story;

class StoryController extends Controller
{

  public function list(Request $request, $campaign_id)
  {
    try {
      $list = Story::where('campaign_id', $campaign_id)->get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    return response()->json(['stories' =>$list]);
  }

  public function save(Request $request) {
    $input = $request->all();

    $validator = Validator::make($input, [
      'id' => 'required',
      'campaign_id'   => 'required',
      'link'          => 'required|url',  // キャンペーン名
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }
    $qid = $input['id'];
    unset($input['id']);
    try {
      if($qid === 0) {
        Story::create($input);
      } else {
        Story::where('id', $qid)->update(['link' => $input['link']]);
      }
    } catch (\Exception $e) {
      return response()->json(['errors' => ['save' => $e->getMessage()]], 400);
    }
    return response()->json(['errors' => []]);
  }
}
