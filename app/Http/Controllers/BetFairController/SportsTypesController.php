<?php

namespace App\Http\Controllers\BetFairController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class SportsTypesController extends BetfairApiController
{ 
    public function getSportsTypes() {
        return view('BetFairViews/sports');
    }

    public function getAllCompetitions() {
        Session::forget('BetSlip');
        $details['competitions'] = $this->getAllCompetitionsApi();
        $details['eventByCountry'] = $this->getEventByCountry();
        $countryCode = $this->getCountryCode();
        $data['countCountry'] = count($countryCode);
        $details['countryCode'] = array_slice($countryCode,0,10, true);
        end($details['countryCode']);
        $data['lastIndexOfCountry'] = key($details['countryCode']);
        //$data['timeRange'] = $this->getTimeRange();
        $data['marketDetails'] = $this->getMarketList();
        return view('BetFairViews/oddsListing',$details,$data);
    }

    public function getNextCountryName(Request $request) {
        $lastIndex = $request->input('lastIndex');
        $data['countryCode'] = $this->getNextCountryItems($lastIndex);
        return view('BetFairViews/listingTopCountries',$data);
    }
}
?>
