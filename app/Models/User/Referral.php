<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Referral extends Model
{
    use HasFactory;

    public static function add_commission( $referrer_data )
    {
        $query = DB::table('referrals')->insert($referrer_data);
        Log::debug('REFERRER::', (array)$query);

        return $query;
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
