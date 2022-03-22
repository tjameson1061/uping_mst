<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Models\Offer\Creatives;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class PartCreativesController extends Controller
{
    public function index(Request $request, $id)
    {
        $creatives = Creatives::where('offer_id', $id)->get();

       return Response::json(['creatives' => $creatives], 200);
    }

    /**
     * @param $site_name
     * @param $country_code
     */
    public function show($site_name, $country_code)
    {

        return view('partner.creatives' . '/' . $site_name . '/' . $country_code);
    }

    /**
     * This email downloads email creatives via header.
     *
     * @param $site_name
     * @param $country_code
     */
    public function download($site_name, $country_code)
    {
        if ($country_code === 'uk') {
            header('Content-disposition: attachment; filename=loan-pal-uk.html');
            header('Content-type: text/html');
        } else {
            header('Content-disposition: attachment; filename=loan-pal-us.html');
            header('Content-type: text/html');
        }
        return view('partner.creatives' . '/' . $site_name . '/' . $country_code);
    }



    public function iframe_form($country_code, $vid)
    {

        if ($country_code === 'uk') {
            return view('partner.creatives.iframe.uk', compact('country_code', 'vid'));
        } else {
            return view('partner.creatives.iframe.us', compact('country_code', 'vid'));
        }
    }

    public function iframe()
    {
        $id = Auth::id();
        $vid = Partner::where('user_id', $id);

        return view('partner.creatives.creatives-list', compact('vid'));
    }

    public function display()
    {
        $id = Auth::id();
        $vid = Partner::where('user_id', $id);

        return view('partner.creatives.creatives-list', compact('vid'));
    }

    public function ads()
    {
        $id = Auth::id();
        $vid = Partner::where('user_id', $id);

        return view('partner.creatives.creatives-list', compact('vid'));
    }

}
