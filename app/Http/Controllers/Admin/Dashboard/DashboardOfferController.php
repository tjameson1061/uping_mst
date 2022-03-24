<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Advertiser\Advertiser;
use App\Models\Buyer\BuyerSetup;
use App\Models\ClickTracker\ClickTracker;
use App\Models\Lead\UKLead;
use App\Models\Offer\Offer;
use App\Models\Partner\Partner;
use App\Models\PostbackTracker\PostbackTracker;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;


class DashboardOfferController extends Controller
{

    public function  getDashboardDataOffer()
    {
        $dashboard_data = [];
        $dashboard_data['todayMetrics'] = $this->todayMetrics();
        $dashboard_data['weekMetrics'] =  $this->weekMetrics();
        $dashboard_data['monthMetrics'] =  $this->monthMetrics();
        $dashboard_data['affiliate_table_data'] = $this->affiiliateOfferCounts();
        $dashboard_data['adv_table_data'] = $this->advertiserOfferCounts();

        return Response::json(['dashboard_data' => $dashboard_data], 200);

    }

    public function revenueOfferChartData(Request $request)
    {

        $date1 = $request->input('start_date');
        $date2 = $request->input('end_date');
        if ($date1 != null && !empty($date1)) {
            $dates = $this->getInBetweenDays($date1, $date2, 'Y-m-d');
        } else {
            $dates = $this->getLastNDays(14, 'Y-m-d');
        }
        $data = [];
        $data['dates'] = array();
        $data['clicks'] = array();
        $data['conversions'] = array();
        $data['revenue'] = array();
        foreach ($dates as $date) {
            $data['clicks'][] = $this->clickMetricsForDate($date);
            $data['conversions'][] =  $this->conversionMetricsForDate($date);
            $data['revenue'][] =  $this->revenueMetricsForDate($date); }
        return response()->json($data);

    }
    public function clickMetricsForDate($date)
    {
        $result = DB::select("select aff_id,
        substring(created_at,1,10) as date, count(*) as result_count
        from click_trackers
        where substring(created_at,1,10) = '$date'
        group by aff_id, substring(created_at,1,10)");


        if ($result == null) {
            return 0;
        } else {
            return $result[0]->result_count;
        }
    }
    public function revenueMetricsForDate( $date)
    {
        $result = DB::select("select totalRevenue, substring(created_at,1,10) as date, count(*) as result_count
        from postback_trackers
        where substring(created_at,1,10) = '$date'
        group by 'id', substring(created_at,1,10)");


        if ($result == null) {
            return 0;
        } else {
            return $result[0]->result_count;
        }
    }
    public function conversionMetricsForDate( $date)
    {
//       ->where('conversion', 1)->count();
        $result = DB::select("select conversion, substring(created_at,1,10) as date, count(*) as result_count
        from postback_trackers
        where substring(created_at,1,10) = '$date'
        group by 'id', substring(created_at,1,10)");


        if ($result == null) {
            return 0;
        } else {
            return $result[0]->result_count;
        }
    }

    function getInBetweenDays($start, $end, $format = 'd/m')
    {

        $dateArray = array();
        $start = Carbon::createFromFormat('d/m/Y', $start);
        $end = Carbon::createFromFormat('d/m/Y', $end);
        $period = CarbonPeriod::create($start, $end);
        foreach ($period as $date) {
            $dateArray[] = $date->format($format);
        }
        return $dateArray;
    }
    function getLastNDays($days, $format = 'd/m')
    {
        $period = CarbonPeriod::create(Carbon::today()->subDays($days), Carbon::today());
        $dateArray = array();
        foreach ($period as $date) {
            $dateArray[] = $date->format($format);
        }
        return $dateArray;
    }

    //Offer
    public function todayMetrics()
    {


        $click_query =
            DB::table('click_trackers')
                     ->where('created_at', '>=', date('Y-m-d', strtotime("-1 days")))
                ->where('created_at', '<=', date('Y-m-d') . " 23:53:53");

        $converison_query =
            DB::table('postback_logs')
                     ->where('created_at', '>=', date('Y-m-d', strtotime("-1 days")))
                ->where('created_at', '<=', date('Y-m-d') . " 23:53:53");

        $conversion_query_two = $converison_query;

        $today_metrics = [];
        $today_metrics['clicks'] = $click_query->count();
        $today_metrics['conversions'] = $conversion_query_two->count();
        $today_metrics['revenue'] = $converison_query->sum('totalRevenue');
        try {
            $today_metrics['profit'] = $converison_query->count();
        } catch (\Exception $e){
            $today_metrics['profit'] = 0;
        }

        return Response::json(['today_metrics' => $today_metrics], 200);
    }
    private function weekMetrics()
    {
        $click_query =
            DB::table('click_trackers')
                ->where('created_at', '>=', date('Y-m-d', strtotime("-7 days")))
                ->where('created_at', '<=', date('Y-m-d') . " 23:53:53");

        $converison_query =
            DB::table('postback_logs')
                ->where('created_at', '>=', date('Y-m-d', strtotime("-7 days")))
                ->where('created_at', '<=', date('Y-m-d') . " 23:53:53");

        $conversion_query_two = $converison_query;

        $week_metrics = [];
        $week_metrics['clicks'] = $click_query->count();
        $week_metrics['conversions'] = $conversion_query_two->count();
        $week_metrics['revenue'] = $converison_query->sum('totalRevenue');
        try {
            $week_metrics['profit'] = $converison_query->count();
        } catch (\Exception $e){
            $week_metrics['profit'] = 0;
        }

        return Response::json(['week_metrics' => $week_metrics], 200);

    }
    private function monthMetrics()
    {
        $click_query =
            DB::table('click_trackers')
                ->where('created_at', '>=', date('Y-m-d', strtotime("-30 days")))
                ->where('created_at', '<=', date('Y-m-d') . " 23:53:53");

        $converison_query =
            DB::table('postback_logs')
                ->where('created_at', '>=', date('Y-m-d', strtotime("-30 days")))
                ->where('created_at', '<=', date('Y-m-d') . " 23:53:53");

        $conversion_query_two = $converison_query;


        $month_metrics = [];
        $month_metrics['clicks'] = $click_query->count();
        $month_metrics['conversions'] = $conversion_query_two->count();
        $month_metrics['revenue'] = $converison_query->sum('totalRevenue');
        try {
            $month_metrics['profit'] = $converison_query->count();
        } catch (\Exception $e){
            $month_metrics['profit'] = 0;
        }

        return Response::json(['today_metrics' => $month_metrics], 200);

    }
    private function affiiliateOfferCounts()
    {

        $vendor_ids = PostbackTracker::groupBy('partner_id')->whereNotNull('partner_id')->get(['partner_id'])->take(5);

        foreach ($vendor_ids as $vendor) {
            foreach ($vendor as $k => $v) {


                $revenue = PostbackTracker::where('partner_id', $vendor['partner_id'])->pluck('totalCost')->sum();
                $clicks = ClickTracker::where('aff_id', $vendor['id'])->count();
                $conversions = PostbackTracker::where('partner_id', $vendor['partner_id'])->count();

                $cost = PostbackTracker::where('partner_id', $vendor['partner_id'])->pluck('totalRevenue')->sum();
                $leads = PostbackTracker::where('partner_id', $vendor['partner_id'])->count();

                $vid = Partner::where('id', $vendor->partner_id)->first();

                $vendor->vid = $vid->vendor_id;
                $vendor->clicks = $clicks;
                $vendor->conversions = $conversions;
                $vendor->leads = $leads;
                $vendor->revenue =  $revenue;

                try {
                    $profit = $revenue - $cost;
                } catch (\Exception $e) {
                    $profit = 0;
                }
                $vendor->profit =  $profit;
            }
        }
        return $vendor_ids;
    }
    private function advertiserOfferCounts()
    {

        $offer_ids = PostbackTracker::groupBy('offer_id')->whereNotNull('offer_id')->get(['offer_id'])->take(5);
//        dd($offer_ids);

        foreach ($offer_ids as $offer) {
            foreach ($offer as $k => $v) {


                $revenue = PostbackTracker::where('offer_id', $offer['offer_id'])->pluck('totalCost')->sum();
                $cost = PostbackTracker::where('offer_id', $offer['offer_id'])->pluck('totalRevenue')->sum();
                $clicks = ClickTracker::where('offer_id', $offer['offer_id'])->count();
                $conversions = PostbackTracker::where('offer_id', $offer['offer_id'])->count();

                $offer_obj = Offer::where('id', $offer->offer_id)->first();

                $offer->name = $offer_obj->name;
                $offer->clicks = $clicks;
                $offer->conversions = $conversions;
                $offer->revenue =  $revenue;

                try {
                    $profit = $revenue - $cost;
                } catch (\Exception $e) {
                    $profit = 0;
                }
                $offer->profit =  $profit;
            }
        }
//        dd($offer_ids);
        return $offer_ids;
    }
    //Leads
    public function profitEarnings()
    {
        $buyerLeadPrice = UKLead::where('created_at', '>=', date('Y-m-d', strtotime("-1 days")))
            ->where('created_at', '<=', date('Y-m-d') . " 23:53:53")->pluck('buyerLeadPrice')->sum();
        $vidLeadPrice = UKLead::where('created_at', '>=', date('Y-m-d', strtotime("-1 days")))
            ->where('created_at', '<=', date('Y-m-d') . " 23:53:53")->pluck('vidLeadPrice')->sum();
        $profit= [];

        try {
            $profit['profit'] = $buyerLeadPrice - $vidLeadPrice ;
        } catch (\Exception $e) {
            $profit['profit']  = 0;
        }

        $profit['lead_count'] = UKLead::where('created_at', Carbon::today())->count();
        return $profit;


    }


























    public function indexUS()
    {
        $leads = LmsPaydayUS::orderBy('id', 'DESC')->get();

        $revenue = Metrics::lead_counts_us();
        $redirectionrate = Metrics::redirection_rate_us();

        $buyer_activity = $this->buyer_activity_us();
        $partner_activity = $this->partner_activity_us();

        if ($revenue['todayRevenue'] === 0) {
            $epa_today = 0;
        } else {
            try {
                $epa_today = $revenue['todayRevenue'] / count($revenue['todayLead']);
            } catch (\Exception $e) {
                $epa_today = 0;
            }
            try {
                $epa_week = $revenue['weeklyRevenue'] / count($revenue['weeklyLead']);
            } catch (\Exception $e) {
                $epa_week = 0;
            }
        }

        if(isset($epa_week)) {
            $epa_week = round($epa_week, 2);
        } else {
            $epa_week = 0;
        }
        if(isset($epa_week)) {
            $epa_today = round($epa_today, 2);
        } else {
            $epa_today = 0;

        }


        $vids = LmsPaydayUS::groupBy('vid')->get(['vid']);
        $buyerids = LmsPaydayUS::groupBy('buyerid')->whereNotNull('buyerid')->get(['buyerid']);
        $buyersetups = LmsPaydayUS::groupBy('buyerTierID')->whereNotNull('buyerTierID')->get(['buyerTierID']);
        $subids = LmsPaydayUS::groupBy('subid')->whereNotNull('subid')->get(['subid']);

        $notifications = auth()->user()->unreadNotifications;

        return view('admin.dashboard.dashboard-admin-us',
            compact('notifications', 'vids', 'buyerids', 'buyersetups',
                'subids', 'revenue', 'buyer_activity', 'partner_activity', 'redirectionrate', 'leads', 'epa_week', 'epa_today'
            ));
    }

    public function indexCA()
    {
        $leads = LmsPaydayCA::orderBy('id', 'DESC')->get();
        $revenue = Metrics::lead_counts_ca();
        $redirectionrate = Metrics::redirection_rate_ca();
        $buyer_activity = $this->buyer_activity();
        $partner_activity = $this->partner_activity();

        try {
            $epa_today = $revenue['todayRevenue'] / count($revenue['todayLead']);
        } catch (\Exception $e) {
            $epa_today = 0;
        }
        try {
            $epa_week = $revenue['weeklyRevenue'] / count($revenue['weeklyLead']);
        } catch (\Exception $e) {
            $epa_week = 0;
        }
        $epa_week = round($epa_week, 2);
        $epa_today = round($epa_today, 2);


        $vids = LmsPaydayCA::groupBy('vid')->get(['vid']);
        $buyerids = LmsPaydayCA::groupBy('buyerid')->whereNotNull('buyerid')->get(['buyerid']);
        $buyersetups = LmsPaydayCA::groupBy('buyerTierID')->whereNotNull('buyerTierID')->get(['buyerTierID']);
        $subids = LmsPaydayCA::groupBy('subid')->whereNotNull('subid')->get(['subid']);



        $notifications = auth()->user()->unreadNotifications;

        return view('admin.dashboard.dashboard-admin-ca',
            compact('notifications', 'vids', 'buyerids', 'buyersetups', 'subids', 'revenue',
                'redirectionrate', 'leads', 'epa_week', 'epa_today', 'buyer_activity', 'partner_activity'
            ));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
