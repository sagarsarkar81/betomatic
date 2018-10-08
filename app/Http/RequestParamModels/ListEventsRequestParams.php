<?php

namespace App\Http\RequestParamModels;
use App\Http\RequestParamModels\MarketFilterRequestParams;

class ListEventsRequestParams {
    public $marketFilter;
    public $countryCodes;
    public function __construct() {
        $this->marketFilter = new MarketFilterRequestParams();
    }
}

?>