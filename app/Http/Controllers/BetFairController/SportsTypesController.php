<?php

namespace App\Http\Controllers\BetFairController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Http\RequestParamModels\ListEventTypesRequestParams;
use App\Http\RequestParamModels\ListCompetitionsRequestParams;
use App\Http\RequestParamModels\ListEventsRequestParams;

class SportsTypesController extends Controller
{
    public function getSportsTypes() {
        // $session_token = Session::get('user_token');
        // $url = "https://sportsbook-api.betfair.com/betting/rest/v1/listEventTypes/";
        // $data['listEventTypesRequestParams'] = new ListEventTypesRequestParams();
        // $data['listEventTypesRequestParams']->marketFilter = new MarketFilter();
        // //aa(getDataByCurl($url, $data, $session_token));
        // $sports = getDataByCurl($url, $data, $session_token);
        return view('BetFairViews/sports');
    }

    public function getAllCompetitions() {
        $session_token = Session::get('user_token');
        $url = "https://sportsbook-api.betfair.com/betting/rest/v1/listCompetitions/";
        $data['listCompetitionsRequestParams'] = new ListCompetitionsRequestParams();
        $leagues['competitions'] = getDataByCurl($url, $data, $session_token);
        foreach($leagues['competitions'] as $key=>$value) {
            //echo $value->competition->name;
            //echo $value->competition->id;
            $this->getEventByCompetitions($value->competition->id);
        }
        //return view('BetFairViews/oddsListing', $leagues);
    }

    public function getEventByCompetitions($competitionsId) {
        $session_token = Session::get('user_token');
        $url = "https://sportsbook-api.betfair.com/betting/rest/v1/listEvents/";
        $data['listEventsRequestParams'] = new ListEventTypesRequestParams();
        $data['listEventsRequestParams']->$competitionIds = ["'".$competitionsId."'"];
        dd($data);
        //$events['matches'] = getDataByCurl($url, $data, $session_token);
        //aa(getDataByCurl($url, $data, $session_token));
    }

    public function getCountries() {
        $session_token = Session::get('user_token');
        $url = "https://sportsbook-api.betfair.com/betting/rest/v1/listCountries/";
        $data['listCountriesRequestParams'] = new ListEventsRequestParams();
        $data['listCountriesRequestParams']->countryCodes = [""];
        $country['countryCode'] = getDataByCurl($url, $data, $session_token);
        //aa(getDataByCurl($url, $data, $session_token));
        // foreach($competitions as $key=>$value) {
        //     echo $value->competition->name;
        // }
        return view('BetFairViews/oddsListing', $country);
    }
}

