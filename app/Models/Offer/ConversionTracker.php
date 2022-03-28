<?php

namespace App\Models\Offer;

use App\Models\Partner\PartnerLeadType;
use App\Models\Postback\PostbackLogs;
use App\Models\PostbackTracker\PostbackTracker;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConversionTracker extends Model
{
    use HasFactory;

    public function postback_tracker()
    {
        return $this->hasOne(PostbackTracker::class, 'buyer_filters', 'buyer_id');

    }

    /**
     * This function adds the revenue to the LmsOffersLog
     * @param $data
     * @param $offer
     * @param $partner_detail
     * @return object
     */
    public function add_revenue( $data , $offer , $partner_detail )
    {
        Log::debug('PARTNER::', (array) $partner_detail->vendor_id);

        $data_update = (object)[];
        $data_update->totalCost = $data->amount;
        $data_update->totalRevenue = $data->amount;


        $postback_log = PostbackLogs::update_postback_log($data, $data_update);

        return $postback_log;

    }


    public function update_postback_log($data)
    {
//        dd($data);
//        DB::table('postback_logs')->where('')

        return $data;

    }
    /**
     * @param $offer_data
     * @param $data
     */
    public static function get_offer_conversion_type($offer_data, $data)
    {

        if (!is_object($offer_data)) {
            $offer_data = Offer::where('id', $offer_data)->with([
                'trackings',
                'campaigns',
                'advertiser',
                'target_group',
                'traffic_sources',
                'landers',
                'payout',
                'offer_caps',
                'offer_metrics'
            ])->first();

            $totals = (object)[];
            $totals->payout = $offer_data->payout->payoutAmount;
            $totals->revenue = $offer_data->payout->revenueAmount;

//            dd($offer_data->conversion_type);
            switch ($offer_data->conversion_type) {
                case "1" || "2":
                    dd($data);
                    if (!empty($data->amount)) {
                        $data->totalCost = $offer_data->payout->payoutAmount;
                        $data->totalRevenue = $offer_data->payout->revenueAmount;
                    } else {
                        $data->totalCost = $offer_data->payout->payoutAmount;
                        $data->totalRevenue = $offer_data->payout->revenueAmount;
                    }
                    dd($data);
                    return $data;

                case "3":
                    dd(222);
                    try {
                        $margin = $data->amount - $data->amount * ($totals->payout / $totals->revenue);
                        //                $lender_response['post_price'] - ($lender_response['post_price'] * ($this->partner_detail->margin / 100));
                        $data->totalCost = $data->amount - $margin;
                        $data->totalRevenue = $data->amount;

                        return $data;
                    } catch (\Exception $e) {
                        Log::debug($e);
                        echo 'No {amount} Variable Provided';
                        die();
                    }
            }
        }
        dd(3333);
        return $data;
    }


    /**
     * Non dynamic - TODO
     */
    public function custom_threshold()
    {
        //                if ((int)$row->offer_id == 8) {
//                    switch ((int)$row-->offer_id == 8) {
//                        case 69:
//                        case 59:
//                            $thresholdAmount = 50;
//                            break;
//
//                        case 67:
//                            $thresholdAmount = 22;
//                            break;
//
//                        case 105:
//                            $thresholdAmount = 25;
//                            break;
//
//                        case 122:
//                            $thresholdAmount = 40;
//                            break;
//
//                        case 117:
//                            break;
//
//                    }
//                } elseif ((int)$row->vid == 97 && $row->oid == 7) {
//                    $thresholdAmount = 10;
//                } elseif ((int)$row[0]['vid'] == 69 && $row[0]['oid'] == 7) {
//                    $thresholdAmount = 20;
//                } elseif ((int)$row[0]['vid'] == 122 && $row[0]['oid'] == 7) {
//                    $thresholdAmount = 11;
//                }

    }
}
