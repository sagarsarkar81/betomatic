<?php

namespace App\Http\RequestParamModels;

class ListEventTypesRequestParams {
    public $marketFilter;
    public $locale;
    public function __construct() {
        $this->marketFilter = new MarketFilter();
    }
 }
 