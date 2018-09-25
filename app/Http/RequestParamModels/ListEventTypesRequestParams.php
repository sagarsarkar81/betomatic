<?php

namespace App\Http\RequestParamModels;
use App\Http\RequestParamModels\MarketFilterRequestParams;

class ListEventTypesRequestParams {
    public $marketFilter;
    public $locale;
    public function __construct() {
        $this->marketFilter = new MarketFilterRequestParams();
    }
 }
 