<?php
namespace App\Http\RequestParamModels;
use App\Http\RequestParamModels\MarketFilterRequestParams;

class ListMarketRequestParams {
    public $marketFilter;
    public $currencyCode = ["USD"];
    public function __construct() {
        $this->marketFilter = new MarketFilterRequestParams();
    }
}

?>