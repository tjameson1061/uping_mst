<?php


namespace App\QueryFilters\NumericFilter;



use App\Models\Buyer\BuyerFilter;
use App\QueryFilters\Filter;
use Illuminate\Support\Facades\DB;


class ShouldBe extends Filter
{

    public function applyFilters(
        $builder,
        $value,
        $buyerTierID,
        $condition
    )
    {
        $post = $builder;


        if ($post->buyer_list == null) {
            return $post;
        }

        switch ($condition) {
            case 'MonthlyIncome':
                $query = DB::table('employers')->where('lead_id', $post->uuid);
                $keyColumn = 'monthlyIncome';
                break;
            case 'LoanAmount':
                $query = DB::table('loans')->where('lead_id', $post->uuid);

                $keyColumn = 'loanAmount';
                break;
            case 'MonthlyMortgageRent':
                $query = DB::table('expenses')->where('lead_id', $post->uuid);

                $keyColumn = 'monthlyMortgageRent';
                break;
            case 'MonthsAtAddress':
                $query = DB::table('residences')->where('lead_id', $post->uuid);
                $keyColumn = 'monthsAtAddress';
                break;
            case 'LoanTerms':
                $query = DB::table('loans')->where('lead_id', $post->uuid);
                $keyColumn = 'loanTerms';
                break;
            case 'CreditExpense':
                $query = DB::table('expenses')->where('lead_id', $post->uuid);
                $keyColumn = 'creditExpense';
                break;
            case 'TransportExpense':
                $query = DB::table('expenses')->where('lead_id', $post->uuid);
                $keyColumn = 'transportExpense';
                break;
            case 'OtherExpense':
                $query = DB::table('expenses')->where('lead_id', $post->uuid);
                $keyColumn = 'otherExpense';
                break;
            case 'UtilityExpense':
                $query = DB::table('expenses')->where('lead_id', $post->uuid);
                $keyColumn = 'utilityExpense';
                break;
            case 'FoodExpense':
                $query = DB::table('expenses')->where('lead_id', $post->uuid);
                $keyColumn = 'foodExpense';
                break;
        }


        $query->where($keyColumn, '=', $value);

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

