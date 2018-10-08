<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\soccer_league_details;
use App\soccer_odds_listings;
use App\bet_place_histories;
use App\news_feeds;
use App\btg_leagues;
use App\btg_events;
use App\btg_odds;
use App\btg_combinations;
use App\btg_combination_details;
use App\btg_user_betting_accounts;
use App\btg_accumulator_bet_conditions;
use App\btg_single_bet_conditions;
use App\btg_featured_matches;
use Session;

class SoccerOddsController extends Controller
{
    public function index()
    {
        if(Session::get('user_id') == '')
        {
            return redirect(url('login'));
        }else{
            //aa(Session::get('BetSlipExtraData'));
            if(Session::get('BetSlipExtraData') == null)
            {
                Session::put('BetSlipExtraData',[]);
            }
            $SessionData = Session::get('BetSlipExtraData');
            //aa($SessionData);
            //Session::forget('BetSlip');
            //$date = date("Y-m-d");
            $date = "2018-02-26";
            $GetBookmaker = DB::select("SELECT DISTINCT(odd_bookmakers) FROM `btg_odds` WHERE DATE(updation_date) = '".$date."' ");
            $GetBookmakerArray = json_decode(json_encode($GetBookmaker),true);

            //$GetDataAccordingToBookmaker = btg_odds::select('*')->leftJoin('btg_events', 'btg_events.match_id', '=', 'btg_odds.match_id')->where('odd_bookmakers',$GetBookmakerArray[0]['odd_bookmakers'])->where('market','Full time')->get()->toArray();
            //$GetDataAccordingToBookmaker = DB::select("SELECT * FROM `btg_odds` LEFT JOIN `btg_events` ON btg_odds.match_id = btg_events.match_id WHERE btg_odds.odd_bookmakers = '".$GetBookmakerArray[0]['odd_bookmakers']."' AND btg_odds.market = 'Full time' AND btg_events.match_time >= NOW() ");
            $GetDataAccordingToBookmaker = DB::select("SELECT * FROM `btg_odds` LEFT JOIN `btg_events` ON btg_odds.match_id = btg_events.match_id WHERE btg_odds.odd_bookmakers = '".$GetBookmakerArray[0]['odd_bookmakers']."' AND btg_odds.market = 'Full time' ");
            $GetData = json_decode(json_encode($GetDataAccordingToBookmaker),true);
            foreach($GetData as $key=>$value)
            {
              $league_details =   [];
              $league_details['country_name'] =   $value['country_name'];
              $league_details['league_name']  =   $value['league_name'];

              $leagues[$value['league_id']] = $league_details;
              $LeagueWiseMatch[$value['league_id']][$value['match_id']][] = $value;
            }
            $BookmakerName = $GetBookmakerArray[0]['odd_bookmakers'];
            $GetTopLeagueName = DB::select("SELECT * FROM `btg_top_leagues` LEFT JOIN `btg_leagues` ON btg_top_leagues.league_table_id = btg_leagues.id LIMIT 10");
            $GetTopLeagueList = json_decode(json_encode($GetTopLeagueName),true);
            //aa($GetFeaturedMatch);
            return view('BettingSections/country_by_league',compact('GetBookmakerArray','BookmakerName','GetTopLeagueList','leagues','LeagueWiseMatch','SessionData'));
        }
    }

    public function SetFeaturedMatch()
    {
        $GetFeaturedMatch = btg_featured_matches::with('FeaturedMatch','FeaturedMatchOdds')->where('match_time','>',now())->get()->toArray();
        //aa($GetFeaturedMatch);
        if(count($GetFeaturedMatch) > 0)
        {
            return view('common/featured_match',compact('GetFeaturedMatch'));
        }
        
    }

    public function GetDataAccordingToBookmaker(Request $request)
    {
      $bookmaker = $request->input('BookmakerName');
      //$GetDataAccordingToBookmaker = btg_odds::select('*')->leftJoin('btg_events', 'btg_events.match_id', '=', 'btg_odds.match_id')->where('odd_bookmakers',$bookmaker)->where('market','Full time')->get()->toArray();
      $GetDataAccordingToBookmaker = DB::select("SELECT * FROM `btg_odds` LEFT JOIN `btg_events` ON btg_odds.match_id = btg_events.match_id WHERE btg_odds.odd_bookmakers = '".$bookmaker."' AND btg_odds.market = 'Full time' AND btg_events.match_time >= NOW() ");
      //$GetDataAccordingToBookmaker = DB::select("SELECT * FROM `btg_odds` LEFT JOIN `btg_events` ON btg_odds.match_id = btg_events.match_id WHERE btg_odds.odd_bookmakers = '".$bookmaker."' AND btg_odds.market = 'Full time' ");
      $GetData = json_decode(json_encode($GetDataAccordingToBookmaker),true);
      foreach($GetData as $key=>$value)
      {
        $league_details =   [];
        $league_details['country_name'] =   $value['country_name'];
        $league_details['league_name']  =   $value['league_name'];

        $leagues[$value['league_id']] = $league_details;
        $LeagueWiseMatch[$value['league_id']][$value['match_id']][] = $value;
      }
      //echo "<pre>";
      //print_r($LeagueWiseMatch);
      return view('BettingSections/DataAccordingToBookmaker',compact('leagues','LeagueWiseMatch'));
    }

    public function SoccerLeagueList(Request $request)
    {
        $CurrentDate = date("y-m-d H:i:s");
        $GetLeagueDetails = soccer_league_details::select('league_name','league_id')->where('event_date','<=',$CurrentDate)->distinct()->offset($request->input('sendValue'))->limit(80)->get()->toArray();
        $nextData = $request->input('sendValue') + 80;
        return view('all_league_list',compact('GetLeagueDetails','nextData'));
    }

    public function ScrollLeagueListLoad(Request $request)
    {
        $CurrentDate = date("y-m-d H:i:s");
        $device = $request->input('device');
        if($device == 'Desktop')
        {
            $GetLeagueDetails = soccer_league_details::select('league_name','league_id')->where('event_date','<=',$CurrentDate)->distinct()->offset($request->input('sendValue'))->limit(80)->get()->toArray();
            if(!empty($GetLeagueDetails))
            {
                $nextData = $request->input('sendValue') + 80;
                return view('all_league_list',compact('GetLeagueDetails','nextData'));
            }
        }else{
            $GetLeagueDetails = soccer_league_details::select('league_name','league_id')->where('event_date','<=',$CurrentDate)->distinct()->offset($request->input('sendValue'))->limit(10)->get()->toArray();
            if(!empty($GetLeagueDetails))
            {
                $nextData = $request->input('sendValue') + 10;
                return view('all_league_list',compact('GetLeagueDetails','nextData'));
            }
        }
    }

    public function SoccerOddsListing(Request $request)
    {
        $LeagueList = $request->input('league');
        if(empty($LeagueList))
        {
            return redirect(url('soccer-odds'));
        }
        else{
            $CurrentDate = date("y-m-d H:i:s");
            $GetOddsDetails = array();
            foreach($LeagueList as $value){
                $GetOddsDetails[$value] = soccer_odds_listings::where('league_id',$value)->where('event_date','<=',$CurrentDate)->get()->toArray();
            }
            Session::forget('BetSlip');
            return view('soccer_odds_listing_page',compact('GetOddsDetails'));
        }
    }
    function PrepareBettingData($CheckOddsValue,$BetOdds,$MatchId,$UniqueId,$BetFor,$BetType,$ExtraValue)
    {
        if(!empty($CheckOddsValue))
        {
            $BetPlaceData = array('betslip_id'=>$UniqueId,
                                  'user_id'=>Session::get('user_id'),
                                  'league_id'=>$CheckOddsValue[0]['league_id'],
                                  'match_id'=>$MatchId,
                                  'sports_type'=>'soccer',
                                  'match_half'=>'Full time',
                                  'Odds_type'=>$BetFor,
                                  'market'=>$BetType,
                                  'home_team'=>$CheckOddsValue[0]['match_hometeam_name'],
                                  'away_team'=>$CheckOddsValue[0]['match_awayteam_name'],
                                  'bet_odds'=>$BetOdds,
                                  'bookmaker'=>$CheckOddsValue[0]['odd_bookmakers'],
                                  'odds_extra_value'=>$ExtraValue,
                                  'match_time'=>$CheckOddsValue[0]['match_time']
                                 );
            $BetSlipData = $MatchId.'-'.$BetType.'-'.$BetFor;
                                 
            if(Session::get('BetSlipExtraData'))
            {
                $SlipData = Session::get('BetSlipExtraData');
                array_push($SlipData,$BetSlipData);
                $SessionBetSlipExtraData = Session::put('BetSlipExtraData', $SlipData);Session::save();
            }else{
                $SlipData = array();
                array_push($SlipData,$BetSlipData);
                $SessionBetSlipData = Session::put('BetSlipExtraData', $SlipData);Session::save();
            }
            if(Session::get('BetSlip'))
            {
                $MatchData = Session::get('BetSlip');
                array_push($MatchData,$BetPlaceData);
                $SessionBetSlipData = Session::put('BetSlip', $MatchData);Session::save();
            }
            else{
                $MatchData = array();
                array_push($MatchData,$BetPlaceData);
                $SessionBetSlipData = Session::put('BetSlip', $MatchData);Session::save();
            }
            
        }
    }
    
    public function CheckOddsDetails(Request $request)
    {
        $UniqueId = $request->input('UniqueId');
        $MatchId = $request->input('MatchId');
        $BetFor = $request->input('BetFor');
        $Bookmaker = $request->input('Bookmaker');
        $MatchTime = $request->input('MatchTime');
        $BetType = $request->input('BetType');
        $Market = $request->input('Market');
        $ExtraValue = $request->input('ExtraOdds');
        if($BetType == 'Full time')
        {
            $CheckOddsValue = btg_odds::select('*')->leftJoin('btg_events', 'btg_events.match_id', '=', 'btg_odds.match_id')->where('btg_odds.match_id',$MatchId)->where('btg_odds.odd_bookmakers',$Bookmaker)->where('odds_name',$BetFor)->where('market','Full time')->get()->toArray();
            $BetOdds = $CheckOddsValue[0]['odds_value'];
            $this->PrepareBettingData($CheckOddsValue,$BetOdds,$MatchId,$UniqueId,$BetFor,$BetType,$ExtraValue);
        }else{
            $CheckOddsValue = btg_odds::select('*')->leftJoin('btg_events', 'btg_events.match_id', '=', 'btg_odds.match_id')->where('btg_odds.match_id',$MatchId)->where('btg_odds.odd_bookmakers',$Bookmaker)->where('market',$Market)->where('extra_value',$ExtraValue)->get()->toArray();
            $BetOdds = $CheckOddsValue[0]['odds_value'];
            $this->PrepareBettingData($CheckOddsValue,$BetOdds,$MatchId,$UniqueId,$BetFor,$BetType,$ExtraValue);
        }
        return view('BettingSections/betslip_body',compact('CheckOddsValue','MatchId','BetFor','UniqueId'));
 
    }
    
    public function CheckAccumulatorOdds(Request $request)
    {
        $UniqueId = $request->input('UniqueId');
        $MatchId = $request->input('MatchId');
        $BetFor = $request->input('BetFor');
        $Bookmaker = $request->input('Bookmaker');
        $MatchTime = $request->input('MatchTime');
        $BetType = $request->input('BetType');
        $Market = $request->input('Market');
        $ExtraValue = $request->input('ExtraOdds');
        if($BetType == 'Full time')
        {
            $CheckOddsValue = btg_odds::select('*')->leftJoin('btg_events', 'btg_events.match_id', '=', 'btg_odds.match_id')->where('btg_odds.match_id',$MatchId)->where('btg_odds.odd_bookmakers',$Bookmaker)->where('odds_name',$BetFor)->where('market','Full time')->get()->toArray();
            $BetOdds = $CheckOddsValue[0]['odds_value'];
        }else{
            $CheckOddsValue = btg_odds::select('*')->leftJoin('btg_events', 'btg_events.match_id', '=', 'btg_odds.match_id')->where('btg_odds.match_id',$MatchId)->where('btg_odds.odd_bookmakers',$Bookmaker)->where('market',$Market)->where('extra_value',$ExtraValue)->get()->toArray();
            $BetOdds = $CheckOddsValue[0]['odds_value'];
        }
        return view('BettingSections/betting_slip_accumulator',compact('CheckOddsValue','MatchId','BetFor','UniqueId'));
    }
    
    public function CheckSameMatchId(Request $request)
    {
        $MatchId = $request->input('MatchId');
        $GetSessionBetSlipData = Session::get('BetSlip');
        $Array = array();
        foreach($GetSessionBetSlipData as $key=>$value)
        {
            array_push($Array,$value['match_id']);
        }
        $tmp = array_count_values($Array);
        $cnt = $tmp[$MatchId];
        if($cnt >= 2)
        {
            $var = "match_found";
        }
        else{
            $var = "match_not_found";
        }
        echo $var;
    }

    public function RemoveOddsFromSession(Request $request)
    {
        $BetSlipId = $request->input('BetSlipId');
        $GetSessionBetSlipData = Session::get('BetSlip');
        foreach($GetSessionBetSlipData as $key=>$value)
        {
            if($value['betslip_id'] == $BetSlipId)
            {
                unset($GetSessionBetSlipData[$key]);
                $PostId = $value['copied_post_id'];
                Session::put('BetSlip', $GetSessionBetSlipData);Session::save();
            }
        }
        //echo $PostId;
        //echo "<pre>";
        //print_r($GetSessionBetSlipData);
    }

    public function InputStakeValue(Request $request)
    {
        $BetSlipId = $request->input('UniqueId');
        $Odds_type = $request->input('OddsType');
        $OddsValue = $request->input('OddsValue');
        $StakeAmount = $request->input('StakeAmount');
        $GetSessionSlipData = Session::get('BetSlip');
        foreach($GetSessionSlipData as $key=>$value)
        {
            if($GetSessionSlipData[$key]['betslip_id'] == $BetSlipId)
            {
                //$value['stake_amount'] = $StakeAmount;
                $GetSessionSlipData[$key]['stake_amount'] = $StakeAmount;
                Session::put('BetSlip', $GetSessionSlipData);session::save();
            }
        }
        //echo "<pre>";
        //print_r(Session::get('BetSlip'));
    }
    
    public function BetPlaceData(Request $request)
    {
        $GetSessionBetSlipData = Session::get('BetSlip');
        $BetComments = $request->input('BetComments');
        $PrivacySettings = $request->input('PrivacySettings');
        foreach($GetSessionBetSlipData as $key=>$value)
        {
            /****deduct amount from user balance******/
            $GetBalance = btg_user_betting_accounts::select('amount')->where('user_id',Session::get('user_id'))->get()->toArray();
            $DeductBalance = ($GetBalance[0]['amount'] - $value['stake_amount']);
            $BalanceData = array('amount'=>$DeductBalance,'updation_date'=>date("Y-m-d H:i:s"));
            $UpdateBalanace = btg_user_betting_accounts::where('user_id',Session::get('user_id'))->update($BalanceData);

            /****deduct amount from user balance******/
            $TicketGenerate = rand(1000,10000);
            $BetId = 'BTG'.$TicketGenerate;
            $GetSessionBetSlipData[$key]['user_id'] = Session::get('user_id');
            $PaymentReturn = ($value['bet_odds'] * $value['stake_amount']);
            $GetSessionBetSlipData[$key]['total_return'] = number_format( $PaymentReturn, 2, '.', '' );
            $GetSessionBetSlipData[$key]['odds_extra_value'] = $value['odds_extra_value'];
            $GetSessionBetSlipData[$key]['status'] = 0;
            $GetSessionBetSlipData[$key]['bet_id'] = $BetId;
            $GetSessionBetSlipData[$key]['bet_text'] = $BetComments;
            $GetSessionBetSlipData[$key]['bet_type'] = 'Single';
            $GetSessionBetSlipData[$key]['bet_place_date'] = date("Y-m-d H:i:s");
            /****************Insert Data into News Feed Table**************************/
            $data = array('user_id'=>$GetSessionBetSlipData[$key]['user_id'],
                          'match_id'=>$GetSessionBetSlipData[$key]['match_id'],
                          'bet_id'=>$BetId,
                          'home_team'=>$GetSessionBetSlipData[$key]['home_team'],
                          'away_team'=>$GetSessionBetSlipData[$key]['away_team'],
                          'Odds_type'=>$GetSessionBetSlipData[$key]['Odds_type'],
                          'odds_value'=>$GetSessionBetSlipData[$key]['bet_odds'],
                          'stake_value'=>$GetSessionBetSlipData[$key]['stake_amount'],
                          'total_return'=>$GetSessionBetSlipData[$key]['total_return'],
                          'bet_type'=>$GetSessionBetSlipData[$key]['bet_type'],
                          'likes'=>0,
                          'status'=>1,
                          'copied_post_id'=>$GetSessionBetSlipData[$key]['copied_post_id'],
                          'match_betting_date'=>$GetSessionBetSlipData[$key]['match_time'],
                          'privacy_status'=>$PrivacySettings,
                          'bet_text'=>$BetComments,
                          'creation_date'=>date("Y-m-d H:i:s"),
                          'updation_date'=>date("Y-m-d H:i:s")
                          );
            $InsertNewsFeed = news_feeds::insert($data);
            /**************************************************************************/
            unset($GetSessionBetSlipData[$key]['copied_post_id']);
            Session::put('BetSlip', $GetSessionBetSlipData);
        }
        //aa($GetSessionBetSlipData);
        $InserBetPlaceHistory = bet_place_histories::insert($GetSessionBetSlipData);
        if($InserBetPlaceHistory == true)
        {
            Session::forget('BetSlip');
            echo "success";
        }
    }
    
    public function StakeAccumulatorInSession(Request $request)
    {
        $stake = $request->input('Stake');
        $GetSessionSlipData = Session::get('BetSlip');
        foreach($GetSessionSlipData as $key=>$value)
        {
            //$value['stake_amount'] = $StakeAmount;
            $GetSessionSlipData[$key]['stake_amount'] = $stake;
            Session::put('BetSlip', $GetSessionSlipData);session::save();
        }
    }
    
    public function PlaceAccumulatorBet(Request $request)
    {
        $GetSessionBetSlipData = Session::get('BetSlip');
        $array = array_pluck($GetSessionBetSlipData, 'bet_odds');
        $AccuOdds = 1;
        foreach($array as $key1=>$value1)
        {
            $AccuOdds *= $value1;
        }
        $TotalStake = $GetSessionBetSlipData[0]['stake_amount'];
        $TotalReturn = ($AccuOdds * $TotalStake);
        /****deduct amount from user balance******/
        $GetBalance = btg_user_betting_accounts::select('amount')->where('user_id',Session::get('user_id'))->get()->toArray();
        $DeductBalance = ($GetBalance[0]['amount'] - $TotalStake);
        $BalanceData = array('amount'=>$DeductBalance,'updation_date'=>date("Y-m-d H:i:s"));
        $UpdateBalanace = btg_user_betting_accounts::where('user_id',Session::get('user_id'))->update($BalanceData);
        /****deduct amount from user balance******/
        $BetComments = $request->input('BetComments');
        $PrivacySettings = $request->input('PrivacySettings');
        $TicketGenerate = rand(1000,10000);
        $BetId = 'BTG'.$TicketGenerate;
        $ComboData = array('user_id'=>$GetSessionBetSlipData[0]['user_id'],
                           'ticket_id'=>$BetId,
                           'sports_id'=>'1',
                           'stake_amount'=>$TotalStake,
                           'bookmaker_name'=>$GetSessionBetSlipData[0]['bookmaker'],
                           'total_return'=>number_format((float)$TotalReturn, 2, '.', ''),
                           'status'=>1,
                           'creation_date'=>date("Y-m-d H:i:s"),
                           'updation_date'=>date("Y-m-d H:i:s")
                          );
        $InertCombination = btg_combinations::create($ComboData);
        $lastInsertedId = $InertCombination->id;
        foreach($GetSessionBetSlipData as $key=>$value)
        {
            $GetSessionBetSlipData[$key]['user_id'] = Session::get('user_id');
            $PaymentReturn = ($value['bet_odds'] * $value['stake_amount']);
            $GetSessionBetSlipData[$key]['total_return'] = number_format( $PaymentReturn, 2, '.', '' );
            $GetSessionBetSlipData[$key]['status'] = 0;
            $GetSessionBetSlipData[$key]['ticket_id'] = $BetId;
            $GetSessionBetSlipData[$key]['bet_text'] = $BetComments;
            $GetSessionBetSlipData[$key]['bet_type'] = 'Accumulator';
            $GetSessionBetSlipData[$key]['bet_place_date'] = date("Y-m-d H:i:s");
            /****************Insert Data into News Feed Table**************************/
            $data = array('user_id'=>$GetSessionBetSlipData[$key]['user_id'],
                          'match_id'=>$GetSessionBetSlipData[$key]['match_id'],
                          'bet_id'=>$BetId,
                          'home_team'=>$GetSessionBetSlipData[$key]['home_team'],
                          'away_team'=>$GetSessionBetSlipData[$key]['away_team'],
                          'Odds_type'=>$GetSessionBetSlipData[$key]['Odds_type'],
                          'odds_value'=>$GetSessionBetSlipData[$key]['bet_odds'],
                          'stake_value'=>$TotalStake,
                          'total_return'=>$TotalReturn,
                          'bet_type'=>$GetSessionBetSlipData[$key]['bet_type'],
                          'likes'=>0,
                          'status'=>1,
                          'copied_post_id'=>$GetSessionBetSlipData[$key]['copied_post_id'],
                          'match_betting_date'=>$GetSessionBetSlipData[$key]['match_time'],
                          'privacy_status'=>$PrivacySettings,
                          'bet_text'=>$BetComments,
                          'creation_date'=>date("Y-m-d H:i:s"),
                          'updation_date'=>date("Y-m-d H:i:s")
                          );
            $InsertNewsFeed = news_feeds::insert($data);
            /**************************************************************************/
            unset($GetSessionBetSlipData[$key]['copied_post_id']);
            /*************************************************************************/
            $ComboDataDetails = array('combination_id'=>$lastInsertedId,
                                      'match_id'=>$GetSessionBetSlipData[$key]['match_id'],
                                      'sports_id'=>'1',
                                      'odds_type'=>$GetSessionBetSlipData[$key]['Odds_type'],
                                      'odds_value'=>$GetSessionBetSlipData[$key]['bet_odds'],
                                      'status'=>1,
                                      'creation_date'=>date("Y-m-d H:i:s"),
                                      'updation_date'=>date("Y-m-d H:i:s")
                                     );
            $InsertCominationDetails = btg_combination_details::insert($ComboDataDetails);
            //Session::put('BetSlip', $GetSessionBetSlipData);session::save();
        }
        Session::forget('BetSlip');
        echo "success";
        
    }

    public function GetUserAccountInfo()
    {
        $GetUserId = Session::get('user_id');
        $GetUserBalance = btg_user_betting_accounts::where('user_id',$GetUserId)->get()->toArray();
        echo $GetUserBalance[0]['amount'];
    }

    public function SingleBetInfo()
    {
        $GetSingleBetInfo = btg_single_bet_conditions::get()->toArray();
        //aa($GetSingleBetInfo);
        return view('BettingSections/SingleBetInfo',compact('GetSingleBetInfo'));
    }

    public function AccumulatorBetInfo()
    {
        $GetAccumulatorBetInfo = btg_accumulator_bet_conditions::get()->toArray();
        return view('BettingSections/AccumulatorBetInfo',compact('GetAccumulatorBetInfo'));
    }

    public function CheckMinimumStake(Request $request)
    {
        $SessionData = Session::get('BetSlip');
        $BetType = $request->input('bet_type');
        echo $BetType;
        if($BetType == 'Single')
        {
            $CheckMinStake = btg_single_bet_conditions::all();
            $MinStake = $CheckMinStake[0]->minimum_stake;
            foreach($SessionData as $key=>$value)
            {
                if($value['stake_amount'] < $MinStake)
                {
                    $msg = "error";
                    break;
                }else{
                    $msg = "success";
                }
            }
            echo $msg;
        }else{
            $CheckMinStake = btg_accumulator_bet_conditions::all();
            $MinStake = $CheckMinStake[0]->minimum_stake;
            if($SessionData[0]['stake_amount'] < $MinStake)
            {
                $msg = "error";
            }elseif($SessionData[0]['stake_amount'] == $MinStake){
                $msg = "success";
            }else{
                $msg = "success";
            }
            echo $msg;
        }
        
        
    }

    public function MinimumCombination(Request $request)
    {
        $SessionData = Session::get('BetSlip');
        $CombinationType = $request->input('combination');
        $SessionDataCount = count($SessionData);
        if($CombinationType == 'minimum')
        {
            $CheckMinStake = btg_accumulator_bet_conditions::all();
            $MinCombination = $CheckMinStake[0]->minimum_combination;
            if($SessionDataCount < $MinCombination)
            {
                echo "minimum_combination";
            }
        }else{
            $CheckMinStake = btg_accumulator_bet_conditions::all();
            $MaxCombination = $CheckMinStake[0]->maximum_combination;
            if($SessionDataCount > $MaxCombination)
            {
                echo "maximum_combination";
            }
        }
    }
}
?>
