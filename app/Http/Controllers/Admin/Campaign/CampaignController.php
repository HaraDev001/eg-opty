<?php

namespace App\Http\Controllers\Admin\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Advertiser;
use App\Models\Rank;

class CampaignController extends Controller
{
  public function list(Request $request, $flag)
  {
    try {
      $lists = Campaign::where('status', $flag)->get();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    return response()->json(['campaigns' =>$lists]);
  }

  public function new(Request $request, $flag) {
    $input = $request->all();

    $validator = Validator::make($input, [
      'advertiser_id'   => 'required', // 出稿広告主
      'title'           => 'required',  // キャンペーン名
      'image'           => 'required|file|image|dimensions:width=800,height=200',  // アイキャッチ画像
      'date_start'      => 'required|date',
      'time_start'      => 'required',
      'date_end'        => 'required|date',     // キャンペーン期間
      'time_end'        => 'required',
      'youtube_url'     => 'required|url',  // Youtube予告URL
      'affiliate_pr'    => 'required',    // アフィリエイター向け PR文
      'notes'           => 'required',        // 注意事項
      'mail_redirect_url' => 'required|url',    // 成約除外メアドリダイレクトURL
      'detail_pdf'      => 'nullable',   // 詳細PDF
      'opt_in_method'   => 'required', // オプトイン方式
      'content_type'    => 'nullable', // コンテンツタイプ
      'company_show'    => 'required', // 会社名表示
      'always_posting'  => 'required',       // 常時掲載案件化
      'show_setting'    => 'nullable',  // 表示設定
      'campaign_summary' => 'required',     // キャンペーン概要
      'deposit_amount'  => 'nullable',     // デポジット金額
      'contracts_limit' => 'nullable',     // 成約上限数
      'remarks'         => 'required',      // 備考
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }

    // save banner
    $file = $request->file('image');
    $fname = time() . $file->getClientOriginalName();
    $file->storeAs('public/campaign-banner', $fname);
    $url = url('/storage/campaign-banner/'. $fname);
    $input['image'] = $url;

    // set flag
    $input['status'] = $flag;

    $cat = Campaign::create($input);
    $list = Campaign::with('advertiser')->get();

    return response()->json(['campaigns' => $list]);
  }

  public function edit(Request $request, $flag) {
    $input = $request->all();

    if($request->has('image')) {
      $validator = Validator::make($input, [
        'image' => 'file|image|dimensions:width=800,height=200',  // アイキャッチ画像
      ]);
      if($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
      }
      // save banner
      $file = $request->file('image');
      $fname = time() . $file->getClientOriginalName();
      $file->storeAs('public/campaign-banner', $fname);
      $url = url('/storage/campaign-banner/'. $fname);
      $input['image'] = $url;
    }

    $validator = Validator::make($input, [
      'id' => 'required',
      'advertiser_id'   => 'required', // 出稿広告主
      'title'           => 'required',  // キャンペーン名
      'date_start'      => 'required|date',
      'time_start'      => 'required',
      'date_end'        => 'required|date',     // キャンペーン期間
      'time_end'        => 'required',
      'youtube_url'     => 'required|url',  // Youtube予告URL
      'affiliate_pr'    => 'required',    // アフィリエイター向け PR文
      'notes'           => 'required',        // 注意事項
      'mail_redirect_url' => 'required|url',    // 成約除外メアドリダイレクトURL
      'detail_pdf'      => 'nullable',   // 詳細PDF
      'opt_in_method'   => 'required', // オプトイン方式
      'content_type'    => 'nullable', // コンテンツタイプ
      'company_show'    => 'required', // 会社名表示
      'always_posting'  => 'required',       // 常時掲載案件化
      'show_setting'    => 'nullable',  // 表示設定
      'campaign_summary' => 'required',     // キャンペーン概要
      'deposit_amount'  => 'nullable',     // デポジット金額
      'contracts_limit' => 'nullable',     // 成約上限数
      'remarks'         => 'required',      // 備考
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }

    // set flag
    $input['status'] = $flag;

    try {
      $cat = Campaign::where('id', $input['id'])->update($input);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    $list = Campaign::with('advertiser')->get();

    return response()->json(['campaigns' => $list]);
  }

  public function get(Request $request, $id) {
    if(!isset($id)) {
      return response()->json(['error' => 'wrong id'], 400);
    }
    $affiliate = Campaign::with('advertiser')->find($id);
    return response()->json(['campaign' => $affiliate]);
  }

  public function delete(Request $request, $id) {
    try {
      Campaign::where('id', $id)->delete();
    } catch(\Exception $e) {
      return response()->json(['error' => 'not delete'], 400);
    }
    $list = Campaign::with('advertiser')->get();

    return response()->json(['campaigns' => $list]);
  }

  public function activeAdvertisers(Request $request) {
    try {
      $list = Advertiser::where('status', 1)->get();
    } catch(\Exception $e) {
      return response()->json(['error' => 'not delete'], 400);
    }

    return response()->json(['advertisers' => $list]);
  }

  public function setPeriod(Request $request, $campaign_id) {
    try {
      Campaign::where('id', $campaign_id)->update($request->all());
    } catch(\Exception $e) {
      return response()->json(['error' => 'not delete'], 400);
    }

    return response()->json(['error' => '']);
  }

}
