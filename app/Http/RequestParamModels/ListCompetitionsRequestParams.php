<?php
namespace App\Http\RequestParamModels;
use App\Http\RequestParamModels\MarketFilterRequestParams;

class ListCompetitionsRequestParams {
    public $marketFilter;
    public $eventTypeIds; 
    public function __construct() {
        $this->marketFilter = new MarketFilterRequestParams();
    }
}

?>