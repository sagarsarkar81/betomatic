<?php

namespace App\Http\Controllers\BetFairController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Cache;
use App\Http\RequestParamModels\ListEventTypesRequestParams;
use App\Http\RequestParamModels\ListCompetitionsRequestParams;
use App\Http\RequestParamModels\ListEventsRequestParams;
use App\Http\RequestParamModels\ListMarketCatalogue;
use App\Http\RequestParamModels\ListMarketRequestParams;

class BetfairApiController extends Controller
{
    public $session_token;

    public function __construct() {
        $this->session_token = Session::get('user_token');
    }
   
    public function getAllCompetitionsApi() {
        if (Cache::has('allCompetitions'))
        {
            $competitions = Cache::get('allCompetitions');

            return $competitions;
        } else{
            $url = "https://sportsbook-api.betfair.com/betting/rest/v1/listCompetitions/";
            $data['listCompetitionsRequestParams'] = new ListCompetitionsRequestParams();
            $competitions = collect(getDataByCurl($url, $data, $this->session_token))->pluck('competition.name', 'competition.id')->toArray();
            Cache::put('allCompetitions', $competitions, 1);

            return $competitions;
        }
    }
    
    public function getEventByCountry() {
        if (Cache::has('eventByCountry'))
        {
            $eventsList = Cache::get('eventByCountry');

            return $eventsList;
        } else{
            $url = "https://sportsbook-api.betfair.com/betting/rest/v1/listEvents/";
            $data['listEventsRequestParams'] = new ListEventTypesRequestParams();
            $events = getDataByCurl($url, $data, $this->session_token);
            $eventsCollection = collect($events);
            $eventsList = $eventsCollection->groupBy('event.competitionId')->toArray();
            Cache::put('eventByCountry', $eventsList, 1);

            return $eventsList;
        }
    }

    public function getCountryCode() {
        if (Cache::has('countryCode'))
        {
            $countryCode = Cache::get('countryCode');

            return $countryCode;
        } else{
            $url = "https://sportsbook-api.betfair.com/betting/rest/v1/listCountries/";
            $data['listCountriesRequestParams'] = new ListEventsRequestParams();
            $countryCode = getDataByCurl($url, $data, $this->session_token);
            Cache::put('countryCode', $countryCode, 1);

            return $countryCode;
        }
    }

    public function getMarketList() {
        if (Cache::has('marketList'))
        {
            $marketDetails = Cache::get('marketList');

            return $marketDetails;
        } else{
            $url = "https://sportsbook-api.betfair.com/betting/rest/v1/listMarketCatalogue/";
            $marketCatalogue['listMarketCatalogueRequestParams'] = new ListMarketCatalogue();
            $collection = collect(getDataByCurl($url, $marketCatalogue, $this->session_token))->pluck('marketName', 'marketId');
            $marketList = $collection->filter(function ($value, $key) {
                return $value == "Match Odds";
            })->toArray();
            $marketListArray = array_keys($marketList);
            $url = "https://sportsbook-api.betfair.com/betting/rest/v1/listMarketPrices/";
            $marketPriceList['listMarketPricesRequestParams'] = new ListMarketRequestParams();
            $marketPriceList['listMarketPricesRequestParams']->marketIds =  $marketListArray;
            $allMarketDetails = getDataByCurl($url, $marketPriceList, $this->session_token);
            $marketDetails = collect($allMarketDetails->marketDetails)->groupBy('eventId')->toArray();
            Cache::put('marketList', $marketDetails, 1);

            return $marketDetails;
        }
    }
}

?>
