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
        $details['competitions'] = $this->getAllCompetitionsApi();
        $details['eventByCountry'] = $this->getEventByCountry();
        
        $details['countryCode'] = $this->getCountryCode();
        $data['marketDetails'] = $this->getMarketList();
        
        return view('BetFairViews/oddsListing',$details,$data);
    }
}

