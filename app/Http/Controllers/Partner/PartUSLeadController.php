<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Lead\UKLead;
use App\Models\Lead\USLead;
use App\Models\Partner\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PartUSLeadController extends Controller
{
    public function index(Request $request, $id)
    {
        $perPage = $request->input("perPage");
        $isSortDirDesc = $request->input("isSortDirDesc");
        $sub_id = $request->input("sub_id");
        $tier = $request->input("tier");
        $vidLeadPrice = $request->input("vidLeadPrice");
        $redirection = $request->input("redirection");
        $status = $request->input("leadStatusFilter");
        $query = $request->input("searchQuery");



        $wherelist = array();
        if ($sub_id != null) {
            $wherelist[] = ['subid', '=', $sub_id];
        }
        if ($tier != null) {
            $wherelist[] = ['tier', '=', $tier];
        }
        if ($vidLeadPrice != null) {
            $wherelist[] = ['vidLeadPrice', '=', $vidLeadPrice];
        }
        if ($redirection != null) {
            $wherelist[] = ['isRedirected', '=', $redirection];
        }
        if ($status != null) {
            $wherelist[] = ['leadStatus', '=', $status];
        }

        if ($query != null) {
            $wherelist[] = ['', 'LIKE', $query];
        }

        $vendor_id = Partner::where('user_id', $id)->where('lead_type', 2)->first()->vendor_id;
        $leads = USLead::select('id', 'istest', 'timeout', 'vid', 'subid', 'buyerTierID', 'vidLeadPrice', 'leadStatus', 'isRedirected', 'created_at')
            ->where($wherelist)
            ->where('vid', $vendor_id)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return Response::json(['leads' => $leads]);
    }

}
