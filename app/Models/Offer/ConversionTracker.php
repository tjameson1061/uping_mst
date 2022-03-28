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
//        Log::debug('DATA::', (array) $data);
//        Log::debug('OFFER::', (array) $offer);
        Log::debug('PARTNER::', (array) $partner_detail->vendor_id);

        $totals = (object)[];
        $totals->payout = $offer->payout->payoutAmount;
        $totals->revenue = $offer->payout->revenueAmount;

        $data_update = (object)[];


        $price = $data->amount - $data->amount * ($partner_detail->margin / 100);
        $data_update->totalCost = $price;

        $data_update->totalRevenue = $totals->revenue;

        $postback_log = PostbackLogs::update_postback_log($data, $data_update);

        return $postback_log;
//        if ($offer->conversion_type == 'Revshare' ) {
//
//            $totalRevenue = $data->amount * ($partner_detail->margin / 100) + $data->amount;
//            $data_update->totalCost = $price;
//            $data_update->totalRevenue = $totalRevenue;
//            try {
//
//                $postback_log = PostbackLogs::update_postback_log($data, $data_update);
//
//                return $postback_log;
//            } catch (\Exception $e) {
//                Log::debug($e);
//                echo 'No {amount} Variable Provided';
//                die();
//            }
//        }
//
//        if ($offer->conversion_type == 'CPA') {
//
//            $partner_accumulator_amount = PartnerLeadType::where('vendor_id', '=', $partner_detail->vendor_id)
//                ->where('lead_type', '=', 2)
//                ->first();
//
//            if ($offer->id == 3) {
//                $accumulator_amount = round($partner_accumulator_amount->accuCPAus20, 2);
//                $total_offer_revenue_threshold = round($totals->revenue, 2);
//            } elseif ($offer->id == 4) {
//                $accumulator_amount = round($partner_accumulator_amount->accuCPAus100, 2);
//                $total_offer_revenue_threshold = round($totals->revenue, 2);
//            }
//
//
//
//            if ($accumulator_amount >= $total_offer_revenue_threshold) {
//                $postback_log = PostbackLogs::update_postback_log($data, $data_update);
//            } else {
//                $postback_log = PostbackLogs::update_postback_log_no_conversion($data, $data_update);
//            }
//
//            return $postback_log;
//        }
//
//        if ($offer->conversion_type == "CPL") {
//
//            $partner_accumulator_amount = PartnerLeadType::where('vendor_id', '=', $partner_detail->vendor_id)
//                ->where('lead_type', '=', 1)
//                ->first();
//
//            $accumulator_amount = round($partner_accumulator_amount->accuCPLus20, 2);
//            $total_offer_revenue_threshold = round($totals->revenue, 2);
//
//            if ($accumulator_amount >= $total_offer_revenue_threshold) {
//                $postback_log = PostbackLogs::update_postback_log($data, $data_update);
//            } else {
//                $postback_log = PostbackLogs::update_postback_log_no_conversion($data, $data_update);
//            }
//
//            return $postback_log;
//        }



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
