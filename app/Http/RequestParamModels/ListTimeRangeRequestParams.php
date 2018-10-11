<?php
namespace App\Http\RequestParamModels;
use App\Http\RequestParamModels\MarketFilterRequestParams;

class ListTimeRangeRequestParams {
    public $marketFilter;
    public $timeGranularity = "DAYS";
    public function __construct() {
        $this->marketFilter = new MarketFilterRequestParams();
    }
}

?>