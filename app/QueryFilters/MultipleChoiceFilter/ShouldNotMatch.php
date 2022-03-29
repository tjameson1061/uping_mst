<?php


namespace App\QueryFilters\MultipleChoiceFilter;


use App\Models\Buyer\BuyerFilter;
use App\QueryFilters\Filter;
use Illuminate\Support\Facades\DB;


class ShouldNotMatch extends Filter
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
            case 'Phone':
                $query = DB::table('applicants')->where('lead_id', $post->uuid);
                break;
        }
        $res = $query->whereColumn($values[0], '!=', $values[1])->get();


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

