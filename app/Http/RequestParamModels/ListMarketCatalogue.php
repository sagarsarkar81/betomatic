<?php
namespace App\Http\RequestParamModels;
use App\Http\RequestParamModels\MarketFilterRequestParams;

class ListMarketCatalogue {
    public $marketFilter;
    public $maxResults = "100";
    public function __construct() {
        $this->marketFilter = new MarketFilterRequestParams();
    }
}

?>