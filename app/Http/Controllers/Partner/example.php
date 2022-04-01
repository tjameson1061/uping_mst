<?php

/**
 * @param Request $request
 * @param $id
 * @return \Illuminate\Http\JsonResponse
 */
public function revenueChartData(Request $request, $id)
{
    $partner = Partner::where('user_id', $id)->where('lead_type', 1)->first();
    $vendor_id = $partner->vendor_id;


    $date1 = $request->input('start_date');
    $date2 = $request->input('end_date');
    if ($date1 != null && !empty($date1)) {
        $dates = $this->getInBetweenDays($date1, $date2, 'Y-m-d');
    } else {
        $dates = $this->getLastNDays(14, 'Y-m-d');
    }
    $data = [];
    $data['dates'] = array();
    $data['accepted'] = array();
    $data['rejected'] = array();
    $data['pending'] = array();
    foreach ($dates as $date) {
        $data['dates'][] = Carbon::createFromFormat('Y-m-d', $date)->format('d M');
        $data['accepted'][] = $this->getLeadStatusForDate(1, $date, $vendor_id);
        $data['rejected'][] = $this->getLeadStatusForDate(2, $date, $vendor_id);
        $data['pending'][] = $this->getLeadStatusForDate(3, $date, $vendor_id);
    }
    return response()->json($data);

}

/**
 * Get In Between Days
 *
 * @param $start
 * @param $end
 * @param string $format
 * @return array
 */
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

/**
 * Get Last N Days
 *
 * @param $days
 * @param string $format
 * @return array
 */
function getLastNDays($days, $format = 'd/m')
{
    $period = CarbonPeriod::create(Carbon::today()->subDays($days), Carbon::today());
    $dateArray = array();
    foreach ($period as $date) {
        $dateArray[] = $date->format($format);
    }
    return $dateArray;
}

/**
 * Get the Lead Status For Date's requested
 *
 * @param $leadStatus
 * @param $date
 * @param $vendor_id
 * @return int
 */
public function getLeadStatusForDate($leadStatus, $date, $vendor_id)
{


    $result = DB::select("select leadStatus, substring(created_at,1,10) as date, count(*) as result_count from uk_leads
        where substring(created_at,1,10) = '$date'
        and vid = '$vendor_id'
        and leadStatus = $leadStatus
        group by leadStatus, substring(created_at,1,10)");


    if ($result == null) {
        return 0;
    } else {
        return $result[0]->result_count;
    }
}
