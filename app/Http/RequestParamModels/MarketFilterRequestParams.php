<?php

namespace App\Http\RequestParamModels;

class MarketFilterRequestParams {
    public $timeGranularity;
    public $eventTypeIds = ["1"];
    public $countryCodes;
    public $competitionIds;
    public $timeRange;
    public $marketTypes;
    public function __construct() {
        $this->timeRange = new TimeRange();
    }
}

?>