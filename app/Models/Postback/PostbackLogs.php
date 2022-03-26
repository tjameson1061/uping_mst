<?php

namespace App\Models\Postback;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostbackLogs extends Model
{
    use HasFactory;

    protected $table = 'postback_logs';



    /**
     * @param $request
     * @param $transaction_id
     * @param $offer
     * @return PostbackLog
     */
    public function store($request, $transaction_id, $offer)
    {
        $postback_log = new PostbackLog();
        $postback_log->lead_id = $request->lead_id ?? '';

        if ($offer->internal === "1") {
            $vendor = Partner::where('vendor_id', '=', $request->partner_id)->first();
            $postback_log->partner_id = $vendor->id;
        } else {
            $postback_log->partner_id = $request->partner_id ?? '1';
        }


//        try {
//            $click_log = ClickTracker::where('aff_click_id', '=', $request->aff_sub)->first();
//            $postback_log->click_tracker_id = $click_log->aff_click_id ?? '';
//        } catch (Exception $e) {
//            Log::debug($e);
//        }
//        $postback_log->click_tracker_id = $click_log->aff_click_id ?? '';
        Log::debug('PB::', (array) $request->totalCost);
        $postback_log->offer_id = $request->offer_id ?? $offer->id;
        $postback_log->aff_sub = $request->aff_sub ?? 'NOT PROVIDED';
        $postback_log->aff_sub2 = $request->aff_sub2 ?? 'NOT PROVIDED';
        $postback_log->aff_sub3 = $request->aff_sub3 ?? 'NOT PROVIDED';
        $postback_log->aff_sub4 = $request->aff_sub4 ?? 'NOT PROVIDED';
        $postback_log->aff_sub5 = $request->aff_sub5 ?? 'NOT PROVIDED';
        $postback_log->affiliatePostbackUrl = $request->affiliatePostbackUrl ?? '';
        $postback_log->transaction_id = $transaction_id ??  'NOT PROVIDED';;
        $postback_log->conversion = $request->conversion ?? '1';
        $postback_log->amount = $request->amount ?? '0.00';
        $postback_log->totalCost = $request->totalCost ?? '0.00';
        $postback_log->totalRevenue = $request->totalRevenue ?? '0.00';
        $postback_log->save();
        Log::debug('Postback DEBUG::', (array) $postback_log);

        return $postback_log;


    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $postback_log = PostbackLog::find($id);

        return Response::json($postback_log);
    }

}
