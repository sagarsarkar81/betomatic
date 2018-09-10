<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\btg_odds;

class fetchodds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:soccer-feed-for-odds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch odds from API';

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
        set_time_limit(0);
        //ini_set('memory_limit','1024M');
        $APIkey='73dac184ad13d536393add5354f46bc4888797c9fa3387ed1d55b1e74f281b3c';
        $FromDate = date("Y-m-d");
        $date = strtotime($FromDate);
        $date = strtotime("+1day",$date);
        $ToDate = date("Y-m-d",$date);
        $url="https://apifootball.com/api/?action=get_odds&from=".$FromDate."&to=".$FromDate."&odd_bookmakers='Interwetten.es'&APIkey=".$APIkey;
        $OddsResult = GetRequestFromAPI($url);
        //aa($OddsResult);
        //aa(count($OddsResult[0]));
        foreach($OddsResult as $OddsKey=>$OddsValue)
        {
          $GetOdds = $this->GetOddInfo($OddsValue);
          //aa($GetOdds);
          //$insert = btg_odds::insert($GetOdds);
          foreach($GetOdds as $keyodds=>$valueodds)
          {
            $CheckMatchId = btg_odds::select('id')->where('match_id',$valueodds['match_id'])->where('odd_bookmakers',$valueodds['odd_bookmakers'])->where('odd_date',$valueodds['odd_date'])->where('market',$valueodds['market'])->where('odds_name',$valueodds['odds_name'])->where('odds_value',$valueodds['odds_value'])->where('extra_value',$valueodds['extra_value'])->get()->toArray();
            if(empty($CheckMatchId[0]['id']))
            {
              $insert = btg_odds::insert($valueodds);
            }else{
              $update = btg_odds::where('id',$CheckMatchId[0]['id'])->where('match_id',$valueodds['match_id'])->where('odd_bookmakers',$valueodds['odd_bookmakers'])->where('odd_date',$valueodds['odd_date'])->where('market',$valueodds['market'])->where('odds_name',$valueodds['odds_name'])->where('odds_value',$valueodds['odds_value'])->where('extra_value',$valueodds['extra_value'])->update($valueodds);
            }
          }
        }
    }

  public function GetOddInfo($oddsInfo)
  {
      //aa($oddsInfo);
      $matchId = $oddsInfo['match_id'];
      $odd_date = $oddsInfo['odd_date'];
      $odd_bookmaker = $oddsInfo['odd_bookmakers'];
      unset($oddsInfo['match_id'],$oddsInfo['odd_date'],$oddsInfo['odd_bookmakers']);
      $TotalArray = array();
      foreach($oddsInfo as $key=>$value)
      {
          if (strpos($key,'odd')!==false) 
          {
            $explode = explode("_",$key);
            $market = 'Full time';
            if($explode[1] == '1')
            {
                $odds_name = 'Home';
                $extra_odds = '-';
                $odds_value = $value;
            }elseif($explode[1] == 'x'){
                $odds_name = 'Draw';
                $extra_odds = '-';
                $odds_value = $value;
            }elseif($explode[1] == '2'){
                $odds_name = 'Away';
                $extra_odds = '-';
                $odds_value = $value;
            }elseif((strpos($key,'1x')!==false)||(strpos($key,'12')!==false)||(strpos($key,'x2')!==false)) {
                $market = 'Double chance';
                $explodedKey = explode("_",$key);
                if($explodedKey[1] == '1x'){
                    $odds_name = 'Home/Draw';
                    $extra_odds = '-';
                    $odds_value = $value;
                }elseif($explodedKey[1] == '12'){
                    $odds_name = 'Home/Away';
                    $extra_odds = '-';
                    $odds_value = $value;
                }elseif($explodedKey[1] == 'x2'){
                    $odds_name = 'Draw/Away';
                    $extra_odds = '-';
                    $odds_value = $value;
                }
             }
             $array = array('match_id'=>$matchId,'odd_bookmakers'=>$odd_bookmaker,'odd_date'=>$odd_date,'market'=>$market,'odds_name'=>$odds_name,'odds_value'=>$odds_value,'extra_value'=>$extra_odds,'updation_date'=>date("Y-m-d H:i:s"));
             array_push($TotalArray,$array);
          }elseif (strpos($key,'ah')!==false) {
             $market = 'Asian handicap';
             $x = explode("_",$key);
             if($x[1] == '1'){
                $odds_name = 'Home';
                if(strpos($x[0],'-') !== false){
                    $y = explode("-",$x[0]);
                    if(empty($y[1]))
                    {
                        $extra_odds = '-';
                    }else{
                        $extra_odds = '-'.$y[1];
                    }
                    $odds_value = $value;
                }elseif(strpos($x[0],'+') !== false){
                    $y = explode("+",$x[0]);
                    if(empty($y[1]))
                    {
                        $extra_odds = '-';
                    }else{
                        $extra_odds = '+'.$y[1];
                    }
                    $odds_value = $value;
                }elseif(strpos($x[0],'0') !== false){
                    $extra_odds = 0;
                    $odds_value = $value;
                }
                $array = array('match_id'=>$matchId,'odd_bookmakers'=>$odd_bookmaker,'odd_date'=>$odd_date,'market'=>$market,'odds_name'=>$odds_name,'odds_value'=>$odds_value,'extra_value'=>$extra_odds,'updation_date'=>date("Y-m-d H:i:s"));
                array_push($TotalArray,$array);
             }elseif($x[1] == '2'){
                $odds_name = 'Away';
                if(strpos($x[0],'-') !== false){
                    $y = explode("-",$x[0]);
                    if(empty($y[1]))
                    {
                        $extra_odds = '-';
                    }else{
                        $extra_odds = '-'.$y[1];
                    }
                    $odds_value = $value;
                }elseif(strpos($x[0],'+') !== false){
                    $y = explode("+",$x[0]);
                    if(empty($y[1]))
                    {
                        $extra_odds = '-';
                    }else{
                        $extra_odds = '+'.$y[1];
                    }
                    $odds_value = $value;
                }elseif(strpos($x[0],'0') !== false){
                    $extra_odds = 0;
                    $odds_value = $value;
                }
                $array = array('match_id'=>$matchId,'odd_bookmakers'=>$odd_bookmaker,'odd_date'=>$odd_date,'market'=>$market,'odds_name'=>$odds_name,'odds_value'=>$odds_value,'extra_value'=>$extra_odds,'updation_date'=>date("Y-m-d H:i:s"));
                array_push($TotalArray,$array);
             }  
          }elseif (strpos($key,'o+')!==false) {
             $market = 'Over';
             $x = explode("+",$key);
             $odds_name = '-';
             $extra_odds = $x[1];
             $odds_value = $value;
             $array = array('match_id'=>$matchId,'odd_bookmakers'=>$odd_bookmaker,'odd_date'=>$odd_date,'market'=>$market,'odds_name'=>$odds_name,'odds_value'=>$odds_value,'extra_value'=>$extra_odds,'updation_date'=>date("Y-m-d H:i:s"));
             array_push($TotalArray,$array);
          }elseif (strpos($key,'u+')!==false) {
             $market = 'Under';
             $x = explode("+",$key);
             $odds_name = '-';
             $extra_odds = $x[1];
             $odds_value = $value;
             $array = array('match_id'=>$matchId,'odd_bookmakers'=>$odd_bookmaker,'odd_date'=>$odd_date,'market'=>$market,'odds_name'=>$odds_name,'odds_value'=>$odds_value,'extra_value'=>$extra_odds,'updation_date'=>date("Y-m-d H:i:s"));
             array_push($TotalArray,$array);
          }elseif (strpos($key,'bts')!==false) {
             $market = 'BTS';
             $x = explode("_",$key);
             if($x[1] == 'yes'){
                $odds_name = 'yes';
                $extra_odds = '-';
                $odds_value = $value;
                $array = array('match_id'=>$matchId,'odd_bookmakers'=>$odd_bookmaker,'odd_date'=>$odd_date,'market'=>$market,'odds_name'=>$odds_name,'odds_value'=>$odds_value,'extra_value'=>$extra_odds,'updation_date'=>date("Y-m-d H:i:s"));
                array_push($TotalArray,$array);
            }else{
              $odds_name = 'no';
              $extra_odds = '-';
              $odds_value = $value;
              $array = array('match_id'=>$matchId,'odd_bookmakers'=>$odd_bookmaker,'odd_date'=>$odd_date,'market'=>$market,'odds_name'=>$odds_name,'odds_value'=>$odds_value,'extra_value'=>$extra_odds,'updation_date'=>date("Y-m-d H:i:s"));
              array_push($TotalArray,$array);
            }
          }
      }
      return $TotalArray;
   }
}
