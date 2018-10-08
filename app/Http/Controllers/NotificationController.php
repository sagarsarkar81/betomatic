<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use App\notifications;
use App\news_feeds;
use App\Users;
use App\news_feed_comments;
use Session;

class NotificationController extends Controller
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
    
    public function ReadNotification()
    {
        $user_id = Session::get('user_id');
        $CheckUnreadNotification = notifications::where('to_userid',$user_id)->where('from_userid','!=',$user_id)->where('status',0)->get()->toArray();
        $CountUnreadNotification = count($CheckUnreadNotification);
        echo $CountUnreadNotification;
    }

    public function GetDetailNotificationList()
    {
        $user_id = Session::get('user_id');
        $CheckUnreadNotification = notifications::where('to_userid',$user_id)->where('status',0)->get()->toArray();
        $data = array('status'=>1,'updation_date'=>date("Y-m-d H:i:s"));
        $ReadNotification = notifications::where('to_userid',$user_id)->where('status',0)->update($data);
        $CheckReadNotification = notifications::where('to_userid',$user_id)->where('status',1)->where('from_userid',"!=",$user_id)->orderBy('creation_date','DESC')->limit(5)->offset(0)->get()->toArray();
        return view('NotificationList',compact('CheckReadNotification'));
    }

    public function VisitNotificationDetails()
    {
        $user_id = Session::get('user_id');
        $CheckUnreadNotification = notifications::where('to_userid',$user_id)->where('status',1)->where('from_userid','!=',$user_id)->orderBy('creation_date','DESC')->get()->toArray();
        return view('notification',compact('CheckUnreadNotification'));
    }

    public function VisitNewsFeedPageSelectedNotification($EncryptedId)
    {
        Session::forget('AllComments');
        $base_url = $this->url->to('/');
        $decodedUrl = base64_decode($EncryptedId);
        $NotificationId = substr($decodedUrl, 6, -6);
        /************notification status change************/
        $UpdateArray = array('detail_seen_status'=>1,'updation_date'=>date("Y-m-d H:i:s"));
        $UpdateQuery = notifications::where('id',$NotificationId)->update($UpdateArray);
        /************notification status change************/
        $user_id = Session::get('user_id');
        $GetNotificationDetails = notifications::where('id',$NotificationId)->get()->toArray();
        $GetFeedDetails = news_feeds::where('id',$GetNotificationDetails[0]['incident_id'])->get()->toArray();
        $GetUserDetails = Users::select('id','name','profile_picture')->where('id',$GetFeedDetails[0]['user_id'])->get()->toArray();
        $FetchComments = news_feed_comments::where('post_id',$GetNotificationDetails[0]['incident_id'])->orderBy('creation_date','DESC')->limit(2)->get()->toArray();
        $GetCountComments = news_feed_comments::where('post_id',$GetNotificationDetails[0]['incident_id'])->get()->toArray();
        $GetCount = count($GetCountComments);
        $post_id = $GetNotificationDetails[0]['incident_id'];
        return view('NewsFeedNotification',compact('GetFeedDetails','GetUserDetails','GetNotificationDetails','FetchComments','post_id','GetCount','base_url'));
    }
}
?>
