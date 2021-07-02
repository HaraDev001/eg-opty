<?php
/**
 * Created by PhpStorm.
 * User: darryldecode
 * Date: 4/2/2018
 * Time: 8:40 AM
 */

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Models\LeadExtendAffiliate;
use App\Models\AffiliateLeadTrack;
use App\Models\RegisteredLine;
use App\Models\RegisteredMail;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Lp;

class ContractIncomeController extends Controller
{
  public function affiliateLink(Request $request)
  {
    $input = $request->all();
    $validator = Validator::make($input, [
      'l' => 'required|exists:App\Models\Lp,id',
      'a' => 'required|exists:App\Models\Affiliate,id',
    ]);

    if ($validator->fails()) {
      return back()->withErrors($validator);
    }

    $lp = Lp::find($input['l']);
    $campaign = $lp->campaign;

    if (is_null($campaign)) {
      return back()->withErrors(['error' => 'campaign not exist']);
    }

    $affiliate = Affiliate::find($input['a']);

    $datetime_start = new Carbon($campaign->date_start . ' ' . $campaign->time_start);
    $datetime_end = new Carbon($campaign->date_end . ' ' . $campaign->time_end);

    // check registered 先行アフィリエイタ
    $affiliate_lead = LeadExtendAffiliate::where([
      ['affiliate_id', '=', $affiliate->id],
      ['campaign_id', '=', $campaign->id],
      ['kind', '=', 'lead']
    ])->last();

    if(!is_null($affiliate_lead)) {
      $datetime_lead = new Carbon($affiliate_lead->date_start . ' ' . $affiliate_lead->time_start);
      if($datetime_lead->isBefore($datetime_start)) {
        $datetime_start = $datetime_lead;
      }
    }
    // check registered 延長アフィリエイタ
    $affiliate_extend = LeadExtendAffiliate::where([
      ['affiliate_id', '=', $affiliate->id],
      ['campaign_id', '=', $campaign->id],
      ['kind', '=', 'extend']
    ])->last();

    if(!is_null($affiliate_extend)) {
      $datetime_extend = new Carbon($affiliate_extend->date_start . ' ' . $affiliate_extend->time_start);
      if($datetime_end->isBefore($datetime_extend)) {
        $datetime_end = $datetime_extend;
      }
    }

    // check if link is outdated
    $now = Carbon::now();
    if(!$now->isBetween($datetime_start, $datetime_end)) {
      return back()->withErrors(['error' => 'outdated']);
    }

    $data = [
      'lp_id' => $input['l'],
      'affiliate_id' => $input['a']
    ];

    try {
      AffiliateLeadTrack::create($data);
    } catch (\Exception $e) {
      return back()->withErrors(['error' => 'db error']);
    }
    $link = $lp->url;

    return redirect()->to($link);
  }

  public function mailRegister(Request $request) {
    $input = $request->all();
    $validator = Validator::make($input, [
      'l' => 'required|exists:App\Models\Lp,id',    // lp_id
      'n' => 'required',            // name
      'e' => 'required|email:rfc'   // email
    ]);
    if($validator->fails()) {
      return back()->withErrors($validator);
    }

    // check email duplication
    $record = RegisteredMail::where('lp_id', $input['l'])->where('customer_email', $input['e'])->first();
    if(!is_null($record)) {
      $msg = '名前'.$input['n'].'およびメール'.$input['e'].'はすでに登録されています。';
      return back()->withErrors(['error' => $msg]);
    }

    // save
    try {
      RegisteredMail::create([
        'lp_id' => $input['l'],
        'customer_email' => $input['e'],
        'customer_name' => $input['n']
      ]);
    } catch (\Exception $e) {
      return back()->withErrors(['error' => 'サーバーエラーが発生しました。']);
    }
    return back()->withInput();
  }

  public function lineRegister(Request $request) {
    $input = $request->all();
    $validator = Validator::make($input, [
      'l' => 'required|exists:App\Models\Lp,id',    // lp_id
      'n' => 'required',            // name
      'u' => 'required'   // line_user_id
    ]);
    if($validator->fails()) {
      return back()->withErrors($validator);
    }

    // check line_user_id duplication
    $record = RegisteredLine::where('lp_id', $input['l'])->where('customer_line_id', $input['u'])->first();
    if(!is_null($record)) {
      $msg = '名前'.$input['n'].'およびラインユーザーID '.$input['u'].'はすでに登録されています。';
      return back()->withErrors(['error' => $msg]);
    }

    // save
    try {
      RegisteredLine::create([
        'lp_id' => $input['l'],
        'customer_line_id' => $input['u'],
        'customer_name' => $input['n']
      ]);
    } catch (\Exception $e) {
      return back()->withErrors(['error' => 'サーバーエラーが発生しました。']);
    }
    return back()->withInput();
  }

}