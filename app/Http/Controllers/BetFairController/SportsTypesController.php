<?php

namespace App\Http\Controllers\BetFairController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Http\RequestParamModels\ListEventTypesRequestParams;
use App\Http\RequestParamModels\ListCompetitionsRequestParams;
use App\Http\RequestParamModels\ListEventsRequestParams;
use App\Http\RequestParamModels\ListMarketCatalogue;
use App\Http\RequestParamModels\ListMarketRequestParams;

class SportsTypesController extends Controller
{
    public function getSportsTypes() {
        return view('BetFairViews/sports');
    }

    public function getAllCompetitions() {
        $session_token = Session::get('user_token');
        $url = "https://sportsbook-api.betfair.com/betting/rest/v1/listCompetitions/";
        $data['listCompetitionsRequestParams'] = new ListCompetitionsRequestParams();
        $details['competitions'] = collect(getDataByCurl($url, $data, $session_token))->pluck('competition.name', 'competition.id')->toArray();
        
        $url = "https://sportsbook-api.betfair.com/betting/rest/v1/listEvents/";
        $data['listEventsRequestParams'] = new ListEventTypesRequestParams();
        $events = getDataByCurl($url, $data, $session_token);
        $eventsCollection = collect($events);
        $details['eventByCountry'] = $eventsCollection->groupBy('event.competitionId')->toArray();
        

        $url = "https://sportsbook-api.betfair.com/betting/rest/v1/listCountries/";
        $data['listCountriesRequestParams'] = new ListEventsRequestParams();
        $details['countryCode'] = getDataByCurl($url, $data, $session_token);
        

        $url = "https://sportsbook-api.betfair.com/betting/rest/v1/listMarketCatalogue/";
        $marketCatalogue['listMarketCatalogueRequestParams'] = new ListMarketCatalogue();
        $marketListArray = collect(getDataByCurl($url, $marketCatalogue, $session_token))->pluck('marketName', 'marketId')->toArray();
        $marketList = array_keys($marketListArray);
        //aa($marketList);

        $url = "https://sportsbook-api.betfair.com/betting/rest/v1/listMarketPrices/";
        $marketPriceList['listMarketPricesRequestParams'] = new ListMarketRequestParams();
        $marketPriceList['listMarketPricesRequestParams']->marketIds =  $marketList;
        $allMarketDetails = getDataByCurl($url, $marketPriceList, $session_token);
        $deatils['marketDetails'] = collect($allMarketDetails->marketDetails)->groupBy('eventId')->toArray();
        aa($deatils['marketDetails']);

        return view('BetFairViews/oddsListing',$details);
    }
}

