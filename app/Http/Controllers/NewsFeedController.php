<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\DB;
use App\Users;
use App\news_feeds;
use App\news_feed_likes;
use App\news_feed_comments;
use App\user_profiles;
use App\follow_users;
use App\favourite_sports;
use App\favourite_teams;
use App\favourite_players;
use App\albums;
use App\photo_albums;
use App\edit_profile_settings;
//use App\report_post_types;
//use App\incident_report_post_types;
use App\cms_email_templates;
use App\notifications;
use App\soccer_odds_listings;
use App\comment_likes;
use App\comment_replies;
use Session;
use Mail;

class NewsFeedController extends Controller
{
    protected $url;
    public function __construct(UrlGenerator $url)
    {
        parent::__construct();
        $this->url = $url;
    }

    public function methodName()
    {
        $this->url->to('/');
    }

    public function SearchByUsername(Request $request)
    {
        $username = $request->input('username');
        $SearchQuery = Users::select('id','user_name','profile_picture')->where('user_name', 'like', ''.$username.'%')->get()->toArray();
        return view('common/search_people',compact('SearchQuery','username'));
        //print_r($SearchQuery);
    }

    public function SearchViewAll(Request $request,$username)
    {
        $GetAllUser = Users::where('user_name', 'like', ''.$username.'%')->get()->toArray();
        return view('searchViewAll',compact('username','GetAllUser'));
    }

    public function VisitUserProfile(Request $request,$UserId)
    {
        if(Session::get('user_id') == '')
        {
            return redirect(url('login'));
        }
        $FetchUserData = Users::where('id',$UserId)->get()->toArray();
        $GetAlbum = albums::where('user_id',$UserId)->get()->toArray();
        $FetchProfileData = user_profiles::where('user_id',$UserId)->get()->toArray();
        $FollowingData = follow_users::where('from_userid',$UserId)->get()->toArray();
        $CountFolowing = count($FollowingData);
        $FollowersData = follow_users::where('to_user_id',$UserId)->get()->toArray();
        $CountFollowers = count($FollowersData);
        return view('viewUserProfile',compact('FetchUserData','FetchProfileData','CountFolowing','CountFollowers','GetAlbum'));
    }
    /*public function DisplayBlockArray(Request $request)
    {
        if($request->input('sendValue') == 0)
        {
            $BlockArray = array('0'=>1,'1'=>2,'2'=>3,'3'=>4,'4'=>5,'5'=>6);
        }
        else if($request->input('sendValue') == 6)
        {
            $BlockArray = array('0'=>7,'1'=>8,'2'=>9,'3'=>10,'4'=>11,'5'=>12);
        }
        else if($request->input('sendValue') == 12)
        {
            $BlockArray = array('0'=>13,'1'=>14,'2'=>15,'3'=>16,'4'=>17,'5'=>18);
        }
        $nextData = $request->input('sendValue') + 6;

        //print_r($BlockArray);die;
        return view('blocklist',compact('BlockArray','nextData'));
    }*/

    public function DisplayBlockArray(Request $request)
    {
        Session::forget('BetSlip');
        $user_id = Session::get('user_id');
        $base_url = $this->url->to('/');
        //-------modified on 22-09-2017-----------//
        $GetFollowedUserId = follow_users::select('to_user_id')->where('from_userid',$user_id)->get()->toArray();
        $UserIdArray = array();
        foreach($GetFollowedUserId as $UserId)
        {
            if(!in_array($UserId['to_user_id'],$UserIdArray))
            {
                array_push($UserIdArray,$UserId['to_user_id']);
            }
        }
        $GetCreationDate = follow_users::select('creation_date')->where('from_userid',$user_id)->get()->toArray();
        $DateArray = array();
        foreach($GetCreationDate as $Date)
        {
            if(!in_array($Date['creation_date'],$DateArray))
            {
                array_push($DateArray,$Date['creation_date']);
            }
        }
        //----------------------------------------//
        $UserIdArray = implode(",",$UserIdArray);
        //aa($UserIdArray);
        //$BlockArray = news_feeds::whereIn('user_id',$UserIdArray)->where('status',1)->where('privacy_status',1)->offset($request->input('sendValue'))->limit(6)->orderBy('match_betting_date', 'DESC')->get()->toArray();
        $DistinctBetId = DB::select("SELECT DISTINCT(`bet_id`) FROM `news_feeds` WHERE `user_id` IN (".$UserIdArray.") AND `privacy_status` = '1' ORDER BY `creation_date` DESC LIMIT 6 OFFSET ".$request->input('sendValue')." ");
        $DistinctBetIdArray = json_decode(json_encode($DistinctBetId),true);
        //aa($DistinctBetIdArray);
        
        foreach($DistinctBetIdArray as $key=>$value)
        {
            
            $GetData = news_feeds::where('bet_id',$value)->get()->toArray();
            $BlockData = [];
            //$array = ;
            foreach($GetData as $datakey=>$datavalue)
            {
                $id = $datavalue['id'];
                $user_id = $datavalue['user_id'];
                $match_betting_date = $datavalue['match_betting_date'];
                $bet_comments = $datavalue['bet_text'];
                $Creation_date = $datavalue['creation_date'];
                $BlockData[] = $datavalue;
            }
            //$data[$value['bet_id']] = $BlockData;
            //aa($BlockData);
            $FeedData[$key]['id'] = $id;
            $FeedData[$key]['user_id'] = $user_id;
            $FeedData[$key]['match_betting_date'] = $match_betting_date;
            $FeedData[$key]['bet_text'] = $bet_comments;
            $FeedData[$key]['bet_id'] = $value['bet_id'];
            $FeedData[$key]['creation_date'] = $Creation_date;
            $FeedData[$key]['details'] = $BlockData;
            
        }
        //aa($FeedData);
        if(!empty($FeedData)){
            $nextData = $request->input('sendValue') + 6;
            return view('blocklist',compact('BlockArray','nextData','GetReportItems','base_url','FeedData'));
        }else{
            return 'false';
        }
        //$BlockArray = news_feeds::select('*')->leftJoin('incident_report_post_types', 'news_feeds.id', '=', 'incident_report_post_types.postId')->whereIn('news_feeds.user_id',$UserIdArray)->where('incident_report_post_types.status',1)->offset($request->input('sendValue'))->limit(6)->orderBy('match_betting_date', 'DESC')->get()->toArray();

    }

    public function CheckNewsFeedLikes(Request $request)
    {
        $post_id = $request->input('post_id');
        $ToUserId = $request->input('to_user_id');
        $user_id = Session::get('user_id');
        $CheckQuery = news_feed_likes::where('post_id',$post_id)->where('user_id',$user_id)->get()->toArray();
        //echo "<pre>";
        //print_r($CheckQuery);die;
        if(empty($CheckQuery))
        {
            $data = array('post_id'=>$post_id,
                          'user_id'=>$user_id,
                          'creation_date' => date("Y-m-d H:i:s"),
					                'updation_date' => date("Y-m-d H:i:s")
                        );
            $insert_data = news_feed_likes::insert($data);
            //$CountQuery = news_feed_likes::where('post_id',$post_id)->where('user_id',$user_id)->get()->toArray();
            $CountQuery = news_feed_likes::where('post_id',$post_id)->get()->toArray();
            $FindCount = count($CountQuery);
            $data = array('likes'=>$FindCount,'updation_date'=>date("Y-m-d H:i:s"));
            $UpdateCountNewsFeed = news_feeds::where('id',$post_id)->update($data);
            /************Notification for likes*****************/
            $GetNameOfFromUser =  Users::select('name')->where('id',$user_id)->get()->toArray();
            $GetNameOfToUser =  Users::select('name')->where('id',$ToUserId)->get()->toArray();
            $data = array('from_userid'=>$user_id,
                          'to_userid'=>$ToUserId,
                          'text'=>$GetNameOfFromUser[0]['name'].' likes your betslip',
                          'incident_type'=>'Likes',
                          'incident_id'=>$post_id,
                          'status'=>0,
                          'detail_seen_status'=>0,
                          'creation_date'=>date("Y-m-d H:i:s"),
                          'updation_date' => date("Y-m-d H:i:s")
                          );
            $GenerateNotification = notifications::insert($data);
            /***************************************************/
            if($insert_data == true)
            {
                echo "success";
            }else{
                echo "failed";
            }
            /******************************************************/
        }else{
            $remove_data = news_feed_likes::where('post_id',$post_id)->where('user_id',$user_id)->delete();
            //$CountQuery = news_feed_likes::where('post_id',$post_id)->where('user_id',$user_id)->get()->toArray();
            $CountQuery = news_feed_likes::where('post_id',$post_id)->get()->toArray();
            $FindCount = count($CountQuery);
            $data = array('likes'=>$FindCount,'updation_date'=>date("Y-m-d H:i:s"));
            $UpdateCountNewsFeed = news_feeds::where('id',$post_id)->update($data);
            /********************************************************/
            if($remove_data == true)
            {
                echo "deleted";
            }else{
                echo "failed";
            }
            /***********************************************************/
        }
    }

    public function NewsFeedPostDetails(Request $request)
    {
        $base_url = $this->url->to('/');
        $post_id = $request->input('post_id');
        $user_id = Session::get('user_id');
        $CountLikes = news_feed_likes::where('post_id',$post_id)->get()->toArray();
        $GetCountLikes = count($CountLikes);
        $FetchComments = news_feed_comments::where('post_id',$post_id)->orderBy('creation_date','DESC')->limit(2)->get()->toArray();
        //$GetCountComments = news_feed_comments::where('post_id',$post_id)->get()->toArray();
        //$GetCount = count($GetCountComments);
        $CheckLoggedUserMakeLike = news_feed_likes::where('post_id',$post_id)->where('user_id',$user_id)->get()->toArray();
        $CountComments = news_feed_comments::where('post_id',$post_id)->get()->toArray();
        $GetCount = count($CountComments);

        $CheckLoggedUserMakeComment = news_feed_comments::where('post_id',$post_id)->where('user_id',$user_id)->get()->toArray();


        $GetCountDetails = news_feeds::where('copied_post_id',$post_id)->get()->toArray();
        $GetPostedUserId = news_feeds::select('user_id')->where('id',$post_id)->get()->toArray();
        $CountNumber = count($GetCountDetails);
        /****Clicked on all comments*******/
        $GetClikedAllComments = Session::get('AllComments');
        if(empty($GetClikedAllComments))
        {
            return view('newsFeedpost',compact('FindCount','post_id','FetchComments','CountNumber','GetPostedUserId','GetCountLikes','CheckLoggedUserMakeLike','GetCount','CheckLoggedUserMakeComment','base_url'));
        }else{
            $FetchComments = news_feed_comments::where('post_id',$post_id)->orderBy('creation_date','DESC')->get()->toArray();
            return view('SeeAllCommentsFullData',compact('FindCount','post_id','FetchComments','CountNumber','GetPostedUserId','GetCountLikes','CheckLoggedUserMakeLike','GetCount','CheckLoggedUserMakeComment','base_url'));
        }
        /***********************************/

    }

    public function NewsFeedCommentDetails(Request $request)
    {
        //date_default_timezone_set("Asia/Calcutta");
        $ToUserId = $request->input('to_user_id');
        $post_id = $request->input('post_id');
        $comment = $request->input('comment');
        $user_id = Session::get('user_id');
        $InsertData = array('post_id'=>$post_id,
                                'user_id'=>$user_id,
                                'comments'=>$comment,
                                'creation_date' => date("Y-m-d H:i:s"),
                                'updation_date' => date("Y-m-d H:i:s")
                                );
        $InsertQuery = news_feed_comments::insert($InsertData);
        /*********email notification for comment*******/
        /*$GetCommentedUserName = Users::select('name','email')->where('id',$user_id)->get()->toArray();
        $CheckNotificationForComments = edit_profile_settings::select('user_id','comment')->where('user_id',$user_id)->get()->toArray();
        if(!empty($CheckNotificationForComments))
        {
            if($CheckNotificationForComments[0]['comment'] == 1)
            {
                comments_mail($GetCommentedUserName[0]['email'],$GetCommentedUserName[0]['name']);
            }
        }*/
        /**********************************************/
        /************Notification for comments*****************/
        $GetNameOfFromUser =  Users::select('name')->where('id',$user_id)->get()->toArray();
        $GetNameOfToUser =  Users::select('name')->where('id',$ToUserId)->get()->toArray();
        $data = array('from_userid'=>$user_id,
                      'to_userid'=>$ToUserId,
                      'text'=>$GetNameOfFromUser[0]['name'].' comments on your betslip',
                      'incident_type'=>'Comment',
                      'incident_id'=>$post_id,
                      'status'=>0,
                      'detail_seen_status'=>0,
                      'creation_date'=>date("Y-m-d H:i:s"),
                      'updation_date' => date("Y-m-d H:i:s")
                      );
        $GenerateNotification = notifications::insert($data);
        /***************************************************/
        /*******************************************************/
        /*$CountQuery = news_feed_likes::where('post_id',$post_id)->where('user_id',$user_id)->get()->toArray();
        $FindCount = count($CountQuery);
        $FetchComments = news_feed_comments::where('post_id',$post_id)->limit(2)->get()->toArray();
        $GetCountDetails = news_feeds::where('copied_post_id',$post_id)->get()->toArray();
        $CountNumber = count($GetCountDetails);
        return view('newsFeedpost',compact('FindCount','post_id','FetchComments','CountNumber'));*/
        /********************************************************/
    }
    /**************See all comments*********************/
    public function SeeAllComments(Request $request)
    {
        $var = 'SeeAllComments';
        $SeeAllCommentsClicked = Session::put('AllComments', $var);
        $user_id = Session::get('user_id');
        $post_id = $request->input('post_id');
        $blockData = news_feeds::select('user_id')->where('id',$post_id)->get()->toArray();
        $FetchComments = news_feed_comments::where('post_id',$post_id)->orderBy('creation_date','DESC')->get()->toArray();
        $GetClikedAllComments = Session::get('AllComments');
        return view('SeeAllCommentsPage',compact('FetchComments','user_name','post_id','blockData','GetCount'));
    }
    /***************************************************/
    function SubmitReportAbuse(Request $request)
    {
          $user_id = Session::get('user_id');
          $GetUserName = Users::select('name','email')->where('id',$user_id)->get()->toArray();
          $GetPostedUserId = Users::select('users.id','name','profile_picture')->leftJoin('news_feeds', 'users.id', '=', 'news_feeds.user_id')->where('news_feeds.id',$request->input('postId'))->get()->toArray();
          $ReportData = $request->input();
          if(!empty($ReportData))
          {
                $data = array('user_id'=>$user_id,
                              'postId'=>$request->input('postId'),
                              'reportId'=>$request->input('report'),
                              'postedbyId'=>$GetPostedUserId[0]['id'],
                              'status'=>1,
                              'creation_date'=>date("Y-m-d H:i:s"),
                              'updation_date'=>date("Y-m-d H:i:s")
                              );
                $InsertQuery = incident_report_post_types::insert($data);
                if($InsertQuery == true)
                {
                    $GetEmailTemplate = cms_email_templates::where('slug','report_abuse')->get()->toArray();
                    $email = 'sumit.wgt@gmail.com';
                    if(!empty($GetEmailTemplate))
                    {
                        $msg = preg_replace("/&#?[a-z0-9]+;/i","",$GetEmailTemplate[0]['content']);
                        $msg = str_replace("[user]",$GetUserName[0]['name'],$msg);
                        $data['msg'] = $msg;
                        Mail::send('mail_template', $data, function($message) use($email,$GetEmailTemplate){
                            $message->to($email)->subject($GetEmailTemplate[0]['subject']);
                        });
                    }
                    $request->session()->flash('success', 'Report has been recorded');
                    echo "success";
                }
          }
    }

    public function BetSlipCopy(Request $request)
    {
        $PostId = $request->input('post_id');
        $UniqueId = rand(10000,1000000);
        $CheckOddsValue = news_feeds::where('id',$PostId)->get()->toArray();
        $BetFor = $CheckOddsValue[0]['Odds_type'];
        $Matchid = $CheckOddsValue[0]['match_id'];
        $GetLeagueId = soccer_odds_listings::select('league_id','bookmaker')->where('match_id',$Matchid)->get()->toArray();
        //$CheckOddsValue[0]['betslip_id'] = $UniqueId;
        $Array = array('betslip_id'=>$UniqueId,
                       'user_id'=>$CheckOddsValue[0]['user_id'],
                       'league_id'=>$GetLeagueId[0]['league_id'],
                       'match_id'=>$CheckOddsValue[0]['match_id'],
                       'sports_type'=>'soccer',
                       'bet_type'=>'Single',
                       'match_half'=>'Full time',
                       'home_team'=>$CheckOddsValue[0]['home_team'],
                       'away_team'=>$CheckOddsValue[0]['away_team'],
                       'bet_odds'=>$CheckOddsValue[0]['odds_value'],
                       'bookmaker'=>$GetLeagueId[0]['bookmaker'],
                       'copied_post_id'=>$PostId
                      );
        $session = Session::get('BetSlip');
        if(!empty($session))
        {
            $MatchData = Session::get('BetSlip');
            array_push($MatchData,$Array);
            $SessionBetSlipData = Session::put('BetSlip', $MatchData);
        }
        else{
            $MatchData = array();
            array_push($MatchData,$Array);
            $SessionBetSlipData = Session::put('BetSlip', $MatchData);
        }
        return view('BetSlip2',compact('CheckOddsValue','MatchId','BetFor','UniqueId'));
    }

    public function CountCopy(Request $request)
    {
        $PostId = $request->input('post_id');
        $GetCountDetails = news_feeds::where('copied_post_id',$PostId)->get()->toArray();
        $CountNumber = count($GetCountDetails);
        //print_r($this->NewsFeedPostDetails());
        $GetUserId = news_feeds::select('user_id')->where('id',$PostId)->get()->toArray();
        $GetUserName = Users::select('name')->where('id',$GetUserId[0]['user_id'])->get()->toArray();
        $data = array('CountNumber'=>$CountNumber,'GetUserName'=>$GetUserName[0]['name']);
        header("Content-Type: application/json");
		echo json_encode($data);
    }

    public function CheckBetSlipExistance(Request $request)
    {
        $PostId = $request->input('post_id');
        $CurrentDate = date("Y-m-d H:i:s");
        $CheckBetSlipExitance = news_feeds::select('id')->where('id',$PostId)->where('match_betting_date','<',$CurrentDate)->get()->toArray();
        echo $CheckBetSlipExitance[0]['id'];
    }

    public function DisplayMyBet(Request $request)
    {
        $base_url = $this->url->to('/');
        $user_id = Session::get('user_id');
        $Days = '365';
        $date = \Carbon\Carbon::today()->subDays($Days);
        /*$BlockArray = news_feeds::where('user_id',$user_id)->where('creation_date',">=",date($date))->offset($request->input('sendValue'))->limit(6)->orderBy('creation_date', 'DESC')->get()->toArray();
        //$DistinctBetId = DB::select("SELECT DISTINCT(`bet_id`)s");
        if(!empty($BlockArray)){
            $nextData = $request->input('sendValue') + 6;
            return view('mybet',compact('BlockArray','nextData','GetReportItems','base_url'));
        }else{
            return 'false';
        }*/

        //$UserIdArray = implode(",",$UserIdArray);
        $DistinctBetId = DB::select("SELECT DISTINCT(`bet_id`) FROM `news_feeds` WHERE `user_id` = ".$user_id." AND `privacy_status` = '1' AND `creation_date` >= '".date($date)."' ORDER BY `creation_date` DESC LIMIT 6 OFFSET ".$request->input('sendValue')." ");
        $DistinctBetIdArray = json_decode(json_encode($DistinctBetId),true);
        //aa($DistinctBetIdArray);
        
        foreach($DistinctBetIdArray as $key=>$value)
        {
            
            $GetData = news_feeds::where('bet_id',$value)->get()->toArray();
            $BlockData = [];
            //$array = ;
            foreach($GetData as $datakey=>$datavalue)
            {
                $id = $datavalue['id'];
                $user_id = $datavalue['user_id'];
                $match_betting_date = $datavalue['match_betting_date'];
                $bet_comments = $datavalue['bet_text'];
                $Creation_date = $datavalue['creation_date'];
                $BlockData[] = $datavalue;
            }
            //$data[$value['bet_id']] = $BlockData;
            //aa($BlockData);
            $FeedData[$key]['id'] = $id;
            $FeedData[$key]['user_id'] = $user_id;
            $FeedData[$key]['match_betting_date'] = $match_betting_date;
            $FeedData[$key]['bet_text'] = $bet_comments;
            $FeedData[$key]['bet_id'] = $value['bet_id'];
            $FeedData[$key]['creation_date'] = $Creation_date;
            $FeedData[$key]['details'] = $BlockData;
            
        }
        //aa($FeedData);
        if(!empty($FeedData)){
            $nextData = $request->input('sendValue') + 6;
            return view('mybet',compact('BlockArray','nextData','GetReportItems','base_url','FeedData'));
        }else{
            return 'false';
        }

    }

    public function GetFilteredMyBetData(Request $request)
    {
        $base_url = $this->url->to('/');
        $user_id = Session::get('user_id');
        $Days = $request->input('day');
        $date = \Carbon\Carbon::today()->subDays($Days);
        $BlockArray = news_feeds::where('user_id',$user_id)->where('creation_date','>=',$date)->limit(6)->orderBy('creation_date', 'DESC')->get()->toArray();
        $nextData = $request->input('sendValue') + 6;
        return view('mybet',compact('BlockArray','nextData','GetReportItems','base_url'));
    }

    public function MyBetResponsive(Request $request)
    {
        $base_url = $this->url->to('/');
        $user_id = Session::get('user_id');
        $Days = '365';
        $date = \Carbon\Carbon::today()->subDays($Days);
        /*$BlockArray = news_feeds::where('user_id',$user_id)->where('creation_date',">=",date($date))->offset($request->input('sendValue'))->limit(6)->orderBy('creation_date', 'DESC')->get()->toArray();
        if(!empty($BlockArray))
        {
            $nextData = $request->input('sendValue') + 6;
            return view('MyBetResponsive',compact('BlockArray','nextData','GetReportItems','base_url'));
        }else{
            return 'false';
        }*/
        $DistinctBetId = DB::select("SELECT DISTINCT(`bet_id`) FROM `news_feeds` WHERE `user_id` = ".$user_id." AND `privacy_status` = '1' AND `creation_date` >= '".date($date)."' ORDER BY `match_betting_date` DESC LIMIT 6 OFFSET ".$request->input('sendValue')." ");
        $DistinctBetIdArray = json_decode(json_encode($DistinctBetId),true);
        //aa($DistinctBetIdArray);
        
        foreach($DistinctBetIdArray as $key=>$value)
        {
            
            $GetData = news_feeds::where('bet_id',$value)->get()->toArray();
            $BlockData = [];
            //$array = ;
            foreach($GetData as $datakey=>$datavalue)
            {
                $id = $datavalue['id'];
                $user_id = $datavalue['user_id'];
                $match_betting_date = $datavalue['match_betting_date'];
                $bet_comments = $datavalue['bet_text'];
                $BlockData[] = $datavalue;
            }
            //$data[$value['bet_id']] = $BlockData;
            //aa($BlockData);
            $FeedData[$key]['id'] = $id;
            $FeedData[$key]['user_id'] = $user_id;
            $FeedData[$key]['match_betting_date'] = $match_betting_date;
            $FeedData[$key]['bet_text'] = $bet_comments;
            $FeedData[$key]['bet_id'] = $value['bet_id'];
            $FeedData[$key]['details'] = $BlockData;
            
        }
        //aa($FeedData);
        if(!empty($FeedData)){
            $nextData = $request->input('sendValue') + 6;
            return view('MyBetResponsive',compact('BlockArray','nextData','GetReportItems','base_url','FeedData'));
        }else{
            return 'false';
        }
        
    }

    public function DisplayBlockArrayResponsive(Request $request)
    {
        Session::forget('BetSlip');
        $base_url = $this->url->to('/');
        $user_id = Session::get('user_id');
        //-------modified on 22-09-2017-----------//
        $GetFollowedUserId = follow_users::select('to_user_id')->where('from_userid',$user_id)->get()->toArray();
        $UserIdArray = array();
        foreach($GetFollowedUserId as $UserId)
        {
            if(!in_array($UserId['to_user_id'],$UserIdArray))
            {
                array_push($UserIdArray,$UserId['to_user_id']);
            }

        }
        $GetCreationDate = follow_users::select('creation_date')->where('from_userid',$user_id)->get()->toArray();
        $DateArray = array();
        foreach($GetCreationDate as $Date)
        {
            if(!in_array($Date['creation_date'],$DateArray))
            {
                array_push($DateArray,$Date['creation_date']);
            }
        }
        //----------------------------------------//
        $UserIdArray = implode(",",$UserIdArray);
        $DistinctBetId = DB::select("SELECT DISTINCT(`bet_id`) FROM `news_feeds` WHERE `user_id` IN (".$UserIdArray.") AND `privacy_status` = '1' ORDER BY `match_betting_date` DESC LIMIT 6 OFFSET ".$request->input('sendValue')." ");
        $DistinctBetIdArray = json_decode(json_encode($DistinctBetId),true);
        //aa($DistinctBetIdArray);
        
        foreach($DistinctBetIdArray as $key=>$value)
        {
            
            $GetData = news_feeds::where('bet_id',$value)->get()->toArray();
            $BlockData = [];
            //$array = ;
            foreach($GetData as $datakey=>$datavalue)
            {
                $id = $datavalue['id'];
                $user_id = $datavalue['user_id'];
                $match_betting_date = $datavalue['match_betting_date'];
                $bet_comments = $datavalue['bet_text'];
                $BlockData[] = $datavalue;
            }
            //$data[$value['bet_id']] = $BlockData;
            //aa($BlockData);
            $FeedData[$key]['id'] = $id;
            $FeedData[$key]['user_id'] = $user_id;
            $FeedData[$key]['match_betting_date'] = $match_betting_date;
            $FeedData[$key]['bet_text'] = $bet_comments;
            $FeedData[$key]['bet_id'] = $value['bet_id'];
            $FeedData[$key]['details'] = $BlockData;
            
        }
        //aa($FeedData);
        if(!empty($FeedData)){
            $nextData = $request->input('sendValue') + 6;
            return view('BlocklistResponsive',compact('BlockArray','nextData','GetReportItems','base_url','FeedData'));
        }else{
            return 'false';
        }
        
    }

    public function GetPeoplesLikeDetails(Request $request)
    {
        $postId = $request->input('PostId');
        $user_id = Session::get('user_id');
        $GetPeopleLikeDetails = Users::select('users.id','name','profile_picture')->leftJoin('news_feed_likes', 'users.id', '=', 'news_feed_likes.user_id')->where('news_feed_likes.post_id',$postId)->get()->toArray();
        return view('PeopleLikeDetails',compact('GetPeopleLikeDetails','postId'));
    }

    public function GetNewsFeedCommentsLike(Request $request)
    {
        $user_id = Session::get('user_id');
        $postId = $request->input('PostId');
        $GetPostedUserName = Users::select('users.id','name','profile_picture')->leftJoin('news_feeds', 'users.id', '=', 'news_feeds.user_id')->where('news_feeds.id',$postId)->get()->toArray();
        $CommnetsId = $request->input('CommnetsId');
        $CommentedUserName = Users::select('name','profile_picture')->leftJoin('news_feed_comments', 'users.id', '=', 'news_feed_comments.user_id')->where('news_feed_comments.id',$CommnetsId)->get()->toArray();
        $ToUserId = $request->input('CommentedUserId');
        $CheckUserLikeOnComment = comment_likes::where('post_id',$postId)->where('comment_id',$CommnetsId)->where('from_user_id',$user_id)->get()->toArray();
        if(empty($CheckUserLikeOnComment))
        {
            $data = array('post_id'=>$postId,
                      'comment_id'=>$CommnetsId,
                      'from_user_id'=>$user_id,
                      'to_user_id'=>$ToUserId,
                      'creation_date'=>date("Y-m-d H:i:s"),
                      'updation_date'=>date("Y-m-d H:i:s")
                     );
            $GenerateQuery = comment_likes::insert($data);
            /************Notification for comments*****************/
            if($user_id != $ToUserId)
            {
                $GetNameOfFromUser =  Users::select('name')->where('id',$user_id)->get()->toArray();
                $GetNameOfToUser =  Users::select('name')->where('id',$ToUserId)->get()->toArray();
                $data = array('from_userid'=>$user_id,
                              'to_userid'=>$ToUserId,
                              //'text'=>$GetNameOfFromUser[0]['name'].' has liked '.$CommentedUserName[0]['name']."'s".' comment',
                              'text'=>$GetNameOfFromUser[0]['name'].' has liked to your comment',
                              'incident_type'=>'Comment Like',
                              'incident_id'=>$postId,
                              'status'=>0,
                              'detail_seen_status'=>0,
                              'creation_date'=>date("Y-m-d H:i:s"),
                              'updation_date' => date("Y-m-d H:i:s")
                              );
                $GenerateNotification = notifications::insert($data);
            }

            if($user_id != $GetPostedUserName[0]['id'])
            {
                $GetNameOfFromUser =  Users::select('id','name','gender')->where('id',$user_id)->get()->toArray();
                $GetNameOfToUser =  Users::select('id','name','gender')->where('id',$ToUserId)->get()->toArray();
                $GetNameOfPostedUser =  Users::select('id','name','gender')->where('id',$GetPostedUserName[0]['id'])->get()->toArray();
                if($GetNameOfFromUser[0]['id'] == $GetNameOfToUser[0]['id'] && $GetNameOfFromUser[0]['gender'] == 'male')
                {
                    $text = $GetNameOfFromUser[0]['name'].' has liked his comment to your betslip';
                }elseif($GetNameOfFromUser[0]['id'] == $GetNameOfToUser[0]['id'] && $GetNameOfFromUser[0]['gender'] == 'female')
                {
                    $text = $GetNameOfFromUser[0]['name'].' has liked her comment to your betslip';
                }else{
                    $text = $GetNameOfFromUser[0]['name'].' has liked '.$GetNameOfToUser[0]['name']."'s".' comment to your betslip';
                }
                $data = array('from_userid'=>$user_id,
                              'to_userid'=>$GetPostedUserName[0]['id'],
                              'text'=>$text,
                              'incident_type'=>'Comment Like',
                              'incident_id'=>$postId,
                              'status'=>0,
                              'detail_seen_status'=>0,
                              'creation_date'=>date("Y-m-d H:i:s"),
                              'updation_date' => date("Y-m-d H:i:s")
                              );
                $GenerateNotification = notifications::insert($data);
            }
            /***************************************************/
        }else{
            $RemoveUserLikeOnComment = comment_likes::where('post_id',$postId)->where('comment_id',$CommnetsId)->where('from_user_id',$user_id)->delete();
        }


    }

    public function GetReplyAgainstComment(Request $request)
    {
        $user_id = Session::get('user_id');
        $postId = $request->input('PostId');
        $CommnetsId = $request->input('CommnetsId');
        $CommentedUserName = Users::select('name','profile_picture')->leftJoin('news_feed_comments', 'users.id', '=', 'news_feed_comments.user_id')->where('news_feed_comments.id',$CommnetsId)->get()->toArray();
        $ToUserId = $request->input('CommentedUserId');
        $PostedUserId = $request->input('PostedUserId');
        $RepliedText = $request->input('reply');
        $data = array('post_id'=>$postId,
                      'comment_id'=>$CommnetsId,
                      'replied_text'=>$RepliedText,
                      'from_user_id'=>$user_id,
                      'to_user_id'=>$ToUserId,
                      'creation_date'=>date("Y-m-d H:i:s"),
                      'updation_date' => date("Y-m-d H:i:s")
                     );
        $GenerateQuery = comment_replies::insert($data);
        /************Notification for reply against comments*****************/
        if($user_id != $ToUserId)
        {
            $To_user_id = $ToUserId;
            $GetNameOfFromUser =  Users::select('name')->where('id',$user_id)->get()->toArray();
            $GetNameOfToUser =  Users::select('name')->where('id',$To_user_id)->get()->toArray();
            $data = array('from_userid'=>$user_id,
                          'to_userid'=>$To_user_id,
                          //'text'=>$GetNameOfFromUser[0]['name'].' has replied to '.$CommentedUserName[0]['name']."'s".' comment',
                          'text'=>$GetNameOfFromUser[0]['name'].' has replied to your comment',
                          'incident_type'=>'Reply',
                          'incident_id'=>$postId,
                          'status'=>0,
                          'detail_seen_status'=>0,
                          'creation_date'=>date("Y-m-d H:i:s"),
                          'updation_date' => date("Y-m-d H:i:s")
                          );
            $GenerateNotification = notifications::insert($data);
        }
        if($user_id != $PostedUserId){
            //$To_user_id = $PostedUserId;
            $GetNameOfFromUser =  Users::select('id','name','gender')->where('id',$user_id)->get()->toArray();
            $GetNameOfToUser =  Users::select('id','name','gender')->where('id',$ToUserId)->get()->toArray();
            if($GetNameOfFromUser[0]['id'] == $GetNameOfToUser[0]['id'] && $GetNameOfFromUser[0]['gender'] == 'male')
            {
                $text = $GetNameOfFromUser[0]['name'].' has replied to his comment to your betslip';
            }elseif($GetNameOfFromUser[0]['id'] == $GetNameOfToUser[0]['id'] && $GetNameOfFromUser[0]['gender'] == 'female')
            {
                $text = $GetNameOfFromUser[0]['name'].' has replied to her comment to your betslip';
            }else{
                $text = $GetNameOfFromUser[0]['name'].' has replied to '.$CommentedUserName[0]['name']."'s".' comment to your betslip';
            }
            $data = array('from_userid'=>$user_id,
                          'to_userid'=>$PostedUserId,
                          'text'=>$text,
                          'incident_type'=>'Reply',
                          'incident_id'=>$postId,
                          'status'=>0,
                          'detail_seen_status'=>0,
                          'creation_date'=>date("Y-m-d H:i:s"),
                          'updation_date' => date("Y-m-d H:i:s")
                          );
            $GenerateNotification = notifications::insert($data);
        }
        /*}
        if($user_id != $PostedUserId)
        {
            $GetNameOfFromUser =  Users::select('name')->where('id',$user_id)->get()->toArray();
            $GetNameOfToUser =  Users::select('name')->where('id',$ToUserId)->get()->toArray();
            $data = array('from_userid'=>$user_id,
                          'to_userid'=>$PostedUserId,
                          'text'=>$GetNameOfFromUser[0]['name'].' replied on your betslip',
                          'incident_type'=>'Reply',
                          'incident_id'=>$postId,
                          'status'=>0,
                          'creation_date'=>date("Y-m-d H:i:s"),
                          'updation_date' => date("Y-m-d H:i:s")
                          );
            $GenerateNotification = notifications::insert($data);
        }*/
        /***************************************************/
    }

    public function GetLikeDetailsAgainstComment(Request $request)
    {
        $postId = $request->input('PostId');
        $user_id = Session::get('user_id');
        $CommnetsId = $request->input('CommnetsId');
        $GetPeopleLikeDetails = Users::select('users.id','name','profile_picture')->leftJoin('comment_likes', 'users.id', '=', 'comment_likes.from_user_id')->where('comment_likes.comment_id',$CommnetsId)->get()->toArray();
        return view('PeopleLikeDetails',compact('GetPeopleLikeDetails','postId'));
    }

    public function MyBetPrivacySettings(Request $request)
    {
        $user_id = Session::get('user_id');
        $SelectedPrivacy = $request->input('privacy');
        $PostId = $request->input('postId2');
        $UpdateData = array('privacy_status'=>$SelectedPrivacy,'updation_date'=>date("Y-m-d H:i:s"));
        $UpdateQuery = news_feeds::where('user_id',$user_id)->where('id',$PostId)->update($UpdateData);
        if($UpdateQuery == true)
        {
            echo "success";
        }
    }

    public function GetPrivacyData(Request $request)
    {
        $user_id = Session::get('user_id');
        $postid = $request->input('postId');
        $GetSelectedPrivacy = news_feeds::select('privacy_status')->where('id',$postid)->get()->toArray();
        return view('SelectOptionForPrivacySettings',compact('GetSelectedPrivacy','postid'));
    }

    public function DisplayOldComment(Request $request)
    {
        $user_id = Session::get('user_id');
        $postid = $request->input('postId');
        $commentId = $request->input('CommentsId');
        $GetOldComment = news_feed_comments::where('post_id',$postid)->where('id',$commentId)->get()->toArray();
        return view('FormEditComment',compact('GetOldComment','postid'));
    }

    public function SubmitEditComment(Request $request)
    {
        $user_id = Session::get('user_id');
        $CommentedUserId = $request->input('CommentedUserId');
        $CommentId = $request->input('CommentId');
        $PostId = $request->input('PostId');
        $NewComment = $request->input('NewComment');
        $Data = array('comments'=>$NewComment,'updation_date'=>date("Y-m-d H:i:s"));
        if($user_id == $CommentedUserId)
        {
            $UpdateQuery = news_feed_comments::where('post_id',$PostId)->where('user_id',$CommentedUserId)->where('id',$CommentId)->update($Data);
        }
    }

    public function DeleteComment(Request $request)
    {
        $user_id = Session::get('user_id');
        $CommentId = $request->input('CommentId');
        $PostId = $request->input('PostId');
        $DeleteQueryForComment = news_feed_comments::where('post_id',$PostId)->where('id',$CommentId)->delete();
        $DeleteQueryForReply = comment_replies::where('post_id',$PostId)->where('comment_id',$CommentId)->delete();
        $DeleteQueryForCommentLike = comment_likes::where('post_id',$PostId)->where('comment_id',$CommentId)->delete();

    }

    public function DisplayOldReply(Request $request)
    {
        $user_id = Session::get('user_id');
        $postid = $request->input('postId');
        $commentId = $request->input('CommentsId');
        $replyId = $request->input('replyId');
        $GetOldReply = comment_replies::where('id',$replyId)->where('post_id',$postid)->where('comment_id',$commentId)->get()->toArray();
        return view('FormEditReply',compact('GetOldReply','postid','commentId','replyId'));
    }

    public function SubmitEditReply(Request $request)
    {
        $user_id = Session::get('user_id');
        $RepliedUserId = $request->input('RepliedUserId');
        $CommentId = $request->input('CommentId');
        $PostId = $request->input('PostId');
        $NewReply = $request->input('NewReply');
        $RepliedId = $request->input('RepliedId');
        $Data = array('replied_text'=>$NewReply,'updation_date'=>date("Y-m-d H:i:s"));
        if($user_id == $RepliedUserId)
        {
            $UpdateQuery = comment_replies::where('id',$RepliedId)->where('post_id',$PostId)->where('comment_id',$CommentId)->where('from_user_id',$RepliedUserId)->update($Data);
        }
    }

    public function DeleteReply(Request $request)
    {
        $replyId = $request->input('RepliedId');
        $DeleteQuery = comment_replies::where('id',$replyId)->delete();
    }

    /**
     * Social share
     */
    public function SocialShareFacebook($postId)
    {
      $user_id = Session::get('user_id');
      $GetNotificationDetails = notifications::where('id',$postId)->get()->toArray();
      $GetFeedDetails = news_feeds::where('id',$GetNotificationDetails[0]['incident_id'])->get()->toArray();
      $GetUserDetails = Users::select('id','name','profile_picture')->where('id',$GetFeedDetails[0]['user_id'])->get()->toArray();
      $FetchComments = news_feed_comments::where('post_id',$GetNotificationDetails[0]['incident_id'])->orderBy('creation_date','DESC')->limit(2)->get()->toArray();
      $GetCountComments = news_feed_comments::where('post_id',$GetNotificationDetails[0]['incident_id'])->get()->toArray();
      $GetCount = count($GetCountComments);
      $post_id = $GetNotificationDetails[0]['incident_id'];
      return view('BettingSections/SocialMediaShare',compact('GetFeedDetails','GetUserDetails','GetNotificationDetails','FetchComments','post_id','GetCount'));
    }

    public function SocialShareTwitter($postId)
    {
      $user_id = Session::get('user_id');
      $GetNotificationDetails = notifications::where('id',$postId)->get()->toArray();
      $GetFeedDetails = news_feeds::where('id',$GetNotificationDetails[0]['incident_id'])->get()->toArray();
      $GetUserDetails = Users::select('id','name','profile_picture')->where('id',$GetFeedDetails[0]['user_id'])->get()->toArray();
      $FetchComments = news_feed_comments::where('post_id',$GetNotificationDetails[0]['incident_id'])->orderBy('creation_date','DESC')->limit(2)->get()->toArray();
      $GetCountComments = news_feed_comments::where('post_id',$GetNotificationDetails[0]['incident_id'])->get()->toArray();
      $GetCount = count($GetCountComments);
      $post_id = $GetNotificationDetails[0]['incident_id'];
      return view('BettingSections/SocialMediaShare',compact('GetFeedDetails','GetUserDetails','GetNotificationDetails','FetchComments','post_id','GetCount'));
    }
}
?>
