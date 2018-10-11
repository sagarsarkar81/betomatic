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
use App\Http\RequestParamModels\ListTimeRangeRequestParams;

class BetfairApiController extends Controller
{
    public $session_token;
    public $fromDate;
    public $toDate;

    public function __construct() {
        $this->session_token = Session::get('user_token');
        $fromDate = \Carbon\Carbon::today()->format('Y-m-d\TH:i:s\Z');
        $toDate = \Carbon\Carbon::today()->addDays("7")->format('Y-m-d\TH:i:s\Z');
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
            $data['listEventsRequestParams']->marketFilter->timeRange->from = $fromDate;
            $data['listEventsRequestParams']->marketFilter->timeRange->to = $toDate;
            $data['listEventsRequestParams']->marketFilter->marketTypes = ["MATCH_ODDS"];
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
            $data['listCountriesRequestParams']->marketFilter->timeRange->from = $fromDate;
            $data['listCountriesRequestParams']->marketFilter->timeRange->to = $toDate;
            $data['listCountriesRequestParams']->marketFilter->marketTypes = ["MATCH_ODDS"];
            $countryCode = getDataByCurl($url, $data, $this->session_token);

            Cache::put('countryCode', $countryCode, 3);

            return $countryCode;
        }
    }

    // public function getTimeRange() {
    //     $url = "https://sportsbook-api.betfair.com/betting/rest/v1/listTimeRanges/";
    //     $timeRange['listTimeRangesRequestParams'] = new ListTimeRangeRequestParams();
    //     $timeRange['listTimeRangesRequestParams']->marketFilter->timeRange->from = "2018-10-08T18:30:00Z";
    //     $timeRange['listTimeRangesRequestParams']->marketFilter->timeRange->to = "2018-10-13T18:30:00Z";
    //     $getTimeRange = getDataByCurl($url, $timeRange, $this->session_token);
    // }

    public function getMarketList() {
        if (Cache::has('marketList'))
        {
            $marketDetails = Cache::get('marketList');

            return $marketDetails;
        } else{
            $url = "https://sportsbook-api.betfair.com/betting/rest/v1/listMarketCatalogue/";
            $marketCatalogue['listMarketCatalogueRequestParams'] = new ListMarketCatalogue();
            $marketCatalogue['listMarketCatalogueRequestParams']->marketFilter->timeRange->from = $fromDate;
            $marketCatalogue['listMarketCatalogueRequestParams']->marketFilter->timeRange->to = $toDate;
            $marketCatalogue['listMarketCatalogueRequestParams']->marketFilter->marketTypes = ["MATCH_ODDS"];
            $collection = collect(getDataByCurl($url, $marketCatalogue, $this->session_token))->pluck('marketName', 'marketId');
            $marketList = $collection->filter(function ($value, $key) {
                return $value == "Match Odds";
            })->toArray();
            $marketListArray = array_keys($marketList);
            $url = "https://sportsbook-api.betfair.com/betting/rest/v1/listMarketPrices/";
            $marketPriceList['listMarketPricesRequestParams'] = new ListMarketRequestParams();
            $marketPriceList['listMarketPricesRequestParams']->marketIds =  $marketListArray;
            $marketPriceList['listMarketPricesRequestParams']->marketFilter->timeRange->from = $fromDate;
            $marketPriceList['listMarketPricesRequestParams']->marketFilter->timeRange->to = $toDate;
            $marketPriceList['listMarketPricesRequestParams']->marketFilter->marketTypes = ['MATCH_ODDS'];
            $allMarketDetails = getDataByCurl($url, $marketPriceList, $this->session_token);
            $marketDetails = collect($allMarketDetails->marketDetails)->groupBy('eventId')->toArray();
            Cache::put('marketList', $marketDetails, 1);

            return $marketDetails;
        }
    }

    public function getNextCountryItems($lastIndex) {
        $countryCode = Cache::get('countryCode');
        $topCountries = array_slice($countryCode,$lastIndex+1,10, true);
        return $topCountries;
    }
}

?>
