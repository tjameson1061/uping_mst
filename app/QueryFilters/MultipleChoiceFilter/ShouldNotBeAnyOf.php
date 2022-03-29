<?php


namespace App\QueryFilters\MultipleChoiceFilter;


use App\Models\Buyer\BuyerFilter;
use App\QueryFilters\Filter;
use Illuminate\Support\Facades\DB;


class ShouldNotBeAnyOf extends Filter
{


    public function applyFilters(
        $builder,
        $values,
        $buyerTierID,
        $condition
    )
    {
        $post = $builder;

        if (empty($post->buyer_list)) {
            return $post;
        }



        switch ($condition) {
            case 'MaritalStatus':
                $query = DB::table('applicants')->where('lead_id', $post->uuid);
                $keyColumn = 'maritalStatus';
                break;
            case 'Email':
                $query = DB::table('applicants')->where('lead_id', $post->uuid);
                $keyColumn = 'email';
                break;
            case 'IncomeSource':
                $query = DB::table('employers')->where('lead_id', $post->uuid);
                $keyColumn = 'incomeSource';
                break;
            case 'IncomeCycle':
                $query = DB::table('employers')->where('lead_id', $post->uuid);
                $keyColumn = 'incomeCycle';
                break;
            case 'ResidentialStatus':
                $query = DB::table('residences')->where('lead_id', $post->uuid);
                $keyColumn = 'residentialStatus';
                break;
            case 'InMilitary':
                $query = DB::table('applicants')->where('lead_id', $post->uuid);
                $keyColumn = 'inMilitary';
                break;
            case 'LicenseState':
                $keyColumn = 'licenseState';
                break;
            case 'State':
                $query = DB::table('residences')->where('lead_id', $post->uuid);
                $keyColumn = 'state';
                break;
            case 'BankAccountType':
                $query = DB::table('banks')->where('lead_id', $post->uuid);
                $keyColumn = 'bankAccountType';
                break;
        }




        if ($keyColumn == 'email') {
           $query
               ->where(function ($email_item) use ($values, $keyColumn) {
                   for ($i = 0; $i < count($values); $i++) {
                       $email_item->orwhere($keyColumn, 'like',  '%' . $values[$i] .'%');
                   }
               });

        } else {
                $query->whereNotIn($keyColumn, $values);

        }


       $newQuery = $query->get()->toArray();

        if (!empty($newQuery)) {

            return $post;

        } else {

            $post = BuyerFilter::removeBuyerFromBuyerList(
                $post,
                $buyerTierID
            );
        }
        return $post;
    }
}

