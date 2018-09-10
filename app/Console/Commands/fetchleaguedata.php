<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\btg_leagues;

class fetchleaguedata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:soccer-feed-for-league';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch league data from API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $APIkey='73dac184ad13d536393add5354f46bc4888797c9fa3387ed1d55b1e74f281b3c';
      $url="https://apifootball.com/api/?action=get_leagues&APIkey=".$APIkey;
      $LeagueResult = GetRequestFromAPI($url);
      foreach($LeagueResult as $LeagueKey=>$LeagueValue)
      {
          $LeagueData = array('country_id'=>$LeagueValue['country_id'],
                                'country_name'=>$LeagueValue['country_name'],
                                'league_id'=>$LeagueValue['league_id'],
                                'league_name'=>$LeagueValue['league_name'],
                                'updation_date'=>date("Y-m-d H:i:s")
                              );
          $CheckLeagueExist = btg_leagues::where('country_id',$LeagueValue['country_id'])->get()->toArray();
          if(empty($CheckLeagueExist))
          {
              $InsertQuery = btg_leagues::insert($LeagueData);
          }else{
              $UpdateTable = btg_leagues::where('country_id',$LeagueValue['country_id'])->update($LeagueData);
          }
      }
    }
}
