<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Referral extends Model
{
    use HasFactory;


    /**
     * @param $referrer_data
     * @return bool
     */
    public static function add_commission( $referrer_data )
    {
        $referral = DB::table('referrals')->insert([
            'vendor_id' => $referrer_data['vendor_id'],
            'referrer_id' => $referrer_data['referrer_id'],
            'commission' => $referrer_data['commission'],
            '$affiliate_price' => $referrer_data['affiliate_price'],
            'geo' => $referrer_data['geo']
        ]);

        return $referral;
    }

    public static function getReferrals($id)
    {
        $partner = DB::table('referrals')->where('user_id', '=', $id)->get()->toArray();
        $vid = $partner[0]->id;

        $referrals = DB::table('referrals')
            ->select(
                'vendor_id',
                'commission',
                'created_at',
            )
            ->where('referrer_id', '=', $id)
            ->get()->toArray();

        return $referrals;
    }


    public static function getAllReferrals()
    {
        $records = Referral::all();

        return $records;
    }

}
