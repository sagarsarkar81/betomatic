<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use App\trending_posts;
use App\trending_replies;
use App\trending_actions;
use App\Users;
use App\notifications;

class TrendingController extends Controller
{
    public function TrendingPage()
    {
        if(Session::get('user_id') == '')
        {
            return redirect(url('login'));
        }else{
            return view('trending');
        }
    }
    
    public function PostStory(Request $request)
    {
        $user_id = Session::get('user_id');
        $Data = $request->input();
        $InsertData = array('posted_user_id'=>$user_id,
                            'posted_text'=>$Data['question'],
                            'post_description'=>$Data['description'],
                            'posted_date'=>date("Y-m-d H:i:s")
                            );
        $SaveData = trending_posts::insert($InsertData);
        if($SaveData == true)
        {
            UpdatePoints($user_id,2,'Create discussion.');
            echo "success";
        }
    }
    
    public function GetPostStory(Request $request)
    {
        $user_id = Session::get('user_id');
        $GetTrendingPost = trending_posts::orderBy('posted_date', 'DESC')->get()->toArray();
        $GetRepliedComments = trending_replies::orderBy('replied_date', 'ASC')->get()->toArray();
        return view('trending_post',compact('GetTrendingPost','GetRepliedComments'));
    }
    
    /*public function GetRepliedComments(Request $request)
    {
        $user_id = Session::get('user_id');
        $GetRepliedComments = trending_replies::orderBy('replied_date', 'DESC')->get()->toArray();
        //$GetUserCredentials = trending_posts::select('name','profile_picture')->leftJoin('users', 'users.id', '=', 'trending_posts.posted_user_id')->where('posted_user_id',$user_id)->get()->toArray(); 
        return view('RepliedComment',compact('GetRepliedComments'));
    }*/
    
    public function ReplyFormSubmit(Request $request)
    {
        $user_id = Session::get('user_id');
        $ReplyText = $request->input('replyText');
        $PostedUserId =  $request->input('PostedUserId');
        $PostId = $request->input('postId');
        $data = array('trending_post_id'=>$PostId,
                      'replied_user_id'=>$user_id,
                      'replied_text'=>$ReplyText,
                      'replied_date'=>date("Y-m-d H:i:s")
                      );
        $SaveData = trending_replies::insert($data);
        /************Notification for reply*****************/
        if($user_id != $PostedUserId)
        {
            $CheckCommentExist = notifications::where('from_userid',$user_id)->where('to_userid',$PostedUserId)->where('incident_id',$PostId)->where('incident_type','Post Comment')->get()->toArray();
            $GetNameOfFromUser =  Users::select('name')->where('id',$user_id)->get()->toArray();
            $GetNameOfToUser =  Users::select('name')->where('id',$PostedUserId)->get()->toArray();
            $data = array('from_userid'=>$user_id,
                      'to_userid'=>$PostedUserId,
                      'text'=>$GetNameOfFromUser[0]['name'].' comments on your post',
                      'incident_type'=>'Post Comment',
                      'incident_id'=>$PostId,
                      'status'=>0,
                      'detail_seen_status'=>0,
                      'creation_date'=>date("Y-m-d H:i:s"),
                      'updation_date' => date("Y-m-d H:i:s")
                      );
            if(empty($CheckCommentExist))
            {
                $GenerateNotification = notifications::insert($data);
            }else{
                $UpdateData = array('creation_date'=>date("Y-m-d H:i:s"),'updation_date' => date("Y-m-d H:i:s"));
                $GenerateNotification = notifications::where('from_userid',$user_id)->where('to_userid',$PostedUserId)->where('incident_id',$PostId)->where('incident_type','Post Comment')->update($UpdateData);
            }
        }
        /***************************************************/
        $GetRepliedComments = trending_replies::orderBy('replied_date', 'ASC')->get()->toArray();
        return view('RepliedComment',compact('GetRepliedComments'));
    }
    
    public function TrendingPost(Request $request)
    {
        $user_id = Session::get('user_id');
        $PostId = $request->input('PostId');
        $GetPostedUserId = trending_actions::select('posted_user_id')->leftJoin('trending_posts', 'trending_posts.id', '=', 'trending_actions.post_id')->where('post_id',$PostId)->get()->toArray();
        $PostedUserId = $GetPostedUserId[0]['posted_user_id'];
        $GetLikesCount = trending_actions::where('post_id',$PostId)->where('likes','1')->count('likes');
        $GetDislikeCount = trending_actions::where('post_id',$PostId)->where('dislikes','1')->count('dislikes');
        $GetBitcoinsCount = trending_actions::where('to_user_id',$PostedUserId)->where('post_id',$PostId)->where('bitcoins','1')->count('bitcoins');
        $CheckUserLikePost = trending_actions::where('post_id',$PostId)->where('from_user_id',$user_id)->where('likes','1')->get()->toArray(); 
        $CheckUserDisLikePost = trending_actions::where('post_id',$PostId)->where('from_user_id',$user_id)->where('dislikes','1')->get()->toArray(); 
        return view('TrendingFeed',compact('GetLikesCount','GetDislikeCount','GetBitcoinsCount','PostId','PostedUserId','CheckUserLikePost','CheckUserDisLikePost'));
    }
    
    public function LikesTrendingPost(Request $request)
    {
        $user_id = Session::get('user_id');
        $PostId = $request->input('PostId');
        $PostedUserId = $request->input('PostedUserId');
        $CheckLikes = trending_actions::select('likes')->where('from_user_id',$user_id)->where('to_user_id',$PostedUserId)->where('post_id',$PostId)->get()->toArray();
        if(empty($CheckLikes))
        {
            if($user_id != $PostedUserId){
                $Bitcoin = 1;
            } else{
                $Bitcoin = 0;
            }
            $data = array('from_user_id'=>$user_id,
                          'to_user_id'=>$PostedUserId,
                          'post_id'=>$PostId,
                          'likes'=>1,
                          'dislikes'=>0,
                          'bitcoins'=>$Bitcoin,
                          'share'=>0,
                          'action_date'=>date("Y-m-d H:i:s")
                          );
            $InsertData = trending_actions::insert($data);
            /************Notification for likes*****************/
            if($user_id != $PostedUserId)
            {
                $CheckLikeExist = notifications::where('from_userid',$user_id)->where('to_userid',$PostedUserId)->where('incident_id',$PostId)->where('incident_type','Post')->get()->toArray();
                $GetNameOfFromUser =  Users::select('name')->where('id',$user_id)->get()->toArray();
                $GetNameOfToUser =  Users::select('name')->where('id',$PostedUserId)->get()->toArray();
                $data = array('from_userid'=>$user_id,
                          'to_userid'=>$PostedUserId,
                          'text'=>$GetNameOfFromUser[0]['name'].' likes your post',
                          'incident_type'=>'Post',
                          'incident_id'=>$PostId,
                          'status'=>0,
                          'detail_seen_status'=>0,
                          'creation_date'=>date("Y-m-d H:i:s"),
                          'updation_date' => date("Y-m-d H:i:s")
                          );
                if(empty($CheckLikeExist))
                {
                    $GenerateNotification = notifications::insert($data);
                }else{
                    $UpdateData = array('creation_date'=>date("Y-m-d H:i:s"),'updation_date' => date("Y-m-d H:i:s"));
                    $GenerateNotification = notifications::where('from_userid',$user_id)->where('to_userid',$PostedUserId)->where('incident_id',$PostId)->where('incident_type','Post')->update($UpdateData);
                }
                
                
            }
            /***************************************************/
        }else{
            if($user_id != $PostedUserId){
                $Bitcoin = 1;
            } else{
                $Bitcoin = 0;
            }
            $data = array('from_user_id'=>$user_id,
                          'to_user_id'=>$PostedUserId,
                          'post_id'=>$PostId,
                          'likes'=>1,
                          'dislikes'=>0,
                          'bitcoins'=>$Bitcoin,
                          'share'=>0,
                          'action_date'=>date("Y-m-d H:i:s")
                          );
            $UpdateData = trending_actions::where('from_user_id',$user_id)->where('to_user_id',$PostedUserId)->where('post_id',$PostId)->update($data);
            /************Notification for likes*****************/
            if($user_id != $PostedUserId)
            {
                $CheckLikeExist = notifications::where('from_userid',$user_id)->where('to_userid',$PostedUserId)->where('incident_id',$PostId)->where('incident_type','Post')->get()->toArray();
                $GetNameOfFromUser =  Users::select('name')->where('id',$user_id)->get()->toArray();
                $GetNameOfToUser =  Users::select('name')->where('id',$PostedUserId)->get()->toArray();
                $data = array('from_userid'=>$user_id,
                          'to_userid'=>$PostedUserId,
                          'text'=>$GetNameOfFromUser[0]['name'].' likes your post',
                          'incident_type'=>'Post',
                          'incident_id'=>$PostId,
                          'status'=>0,
                          'detail_seen_status'=>0,
                          'creation_date'=>date("Y-m-d H:i:s"),
                          'updation_date' => date("Y-m-d H:i:s")
                          );
                if(empty($CheckLikeExist))
                {
                    $GenerateNotification = notifications::insert($data);
                }else{
                    $UpdateData = array('creation_date'=>date("Y-m-d H:i:s"),'updation_date' => date("Y-m-d H:i:s"));
                    $GenerateNotification = notifications::where('from_userid',$user_id)->where('to_userid',$PostedUserId)->where('incident_id',$PostId)->where('incident_type','Post')->update($UpdateData);
                }
            }
            /***************************************************/
        }
    }
    
    public function DisLikeTrendingPost(Request $request)
    {
        $user_id = Session::get('user_id');
        $PostId = $request->input('PostId');
        $PostedUserId = $request->input('PostedUserId');
        $CheckLikes = trending_actions::select('likes')->where('from_user_id',$user_id)->where('to_user_id',$PostedUserId)->where('post_id',$PostId)->get()->toArray();
        if(!empty($CheckLikes))
        {
            $data = array('from_user_id'=>$user_id,
                          'to_user_id'=>$PostedUserId,
                          'post_id'=>$PostId,
                          'likes'=>0,
                          'dislikes'=>1,
                          'bitcoins'=>0,
                          'share'=>0,
                          'action_date'=>date("Y-m-d H:i:s")
                          );
            $UpdateData = trending_actions::where('from_user_id',$user_id)->where('to_user_id',$PostedUserId)->where('post_id',$PostId)->update($data);
        }else{
            $data = array('from_user_id'=>$user_id,
                          'to_user_id'=>$PostedUserId,
                          'post_id'=>$PostId,
                          'likes'=>0,
                          'dislikes'=>1,
                          'bitcoins'=>0,
                          'share'=>0,
                          'action_date'=>date("Y-m-d H:i:s")
                          );
            $InsertData = trending_actions::insert($data);
        }
    }
    
    public function SearchByKeywordTrending(Request $request)
    {
        $SearchData = $request->input('SearchData');
        $GetTrendingPost = trending_posts::select('id','posted_user_id','posted_text','post_description','posted_date')->where('posted_text', 'like', '%'.$SearchData.'%')->orderBy('posted_date', 'DESC')->get()->toArray();
        $GetRepliedComments = trending_replies::orderBy('replied_date', 'ASC')->get()->toArray();
        return view('trending_post',compact('GetTrendingPost','GetRepliedComments'));
    }
    
    public function SearchByUserChoice(Request $request)
    {
        $UserChoice = $request->input('UserChoice');
        if($UserChoice == 'Popular')
        {
            $GetTrendingPost = array();
            //$CountTrendingPost = trending_replies::selectRaw('trending_post_id, count(trending_post_id)')->groupBy('trending_post_id')->get()->toArray();
            $CountTrendingPost = trending_replies::select('trending_post_id')->groupBy('trending_post_id')->havingRaw("COUNT(trending_post_id) >= 2")->get()->toArray();
            foreach($CountTrendingPost as $key=>$value)
            {
                $GetPostDetails = trending_posts::select('id','posted_user_id','posted_text','post_description','posted_date')->where('id',$value['trending_post_id'])->get()->toArray()[0];
                $GetTrendingPost[$key]=$GetPostDetails;
            }
            $GetRepliedComments = trending_replies::orderBy('replied_date', 'ASC')->get()->toArray();
            return view('trending_post',compact('GetTrendingPost','GetRepliedComments'));
        }
        else{
            $Days = '7';
            $date = \Carbon\Carbon::today()->subDays($Days);
            $GetTrendingPost = trending_posts::where('posted_date',">=",date($date))->orderBy('posted_date', 'DESC')->get()->toArray();
            $GetRepliedComments = trending_replies::orderBy('replied_date', 'ASC')->get()->toArray();
            return view('trending_post',compact('GetTrendingPost','GetRepliedComments'));
        }
    }
    
    public function SocialShareTrending(Request $request,$postId)
    {
        $GetPostDetails = trending_posts::select('posted_text')->where('id',$postId)->get()->toArray();
        return view('TrendingSocialShare',compact('GetPostDetails'));
    }
    
    public function VisitSelectedUserPost(Request $request,$EncryptedId)
    {
        $decodedUrl = base64_decode($EncryptedId);
        $NotificationId = substr($decodedUrl, 6, -6);
        /************notification status chnage************/
        $UpdateArray = array('detail_seen_status'=>1,'updation_date'=>date("Y-m-d H:i:s"));
        $UpdateQuery = notifications::where('id',$NotificationId)->update($UpdateArray);
        /************notification status chnage************/
        $GetNotificationDetails = notifications::where('id',$NotificationId)->get()->toArray();
        $user_id = Session::get('user_id');
        $PostId = $GetNotificationDetails[0]['incident_id'];
        $GetTrendingPost = trending_posts::where('id',$GetNotificationDetails[0]['incident_id'])->get()->toArray();
        $GetRepliedComments = trending_replies::where('trending_post_id',$GetNotificationDetails[0]['incident_id'])->orderBy('replied_date', 'DESC')->get()->toArray();
        return view('TrendingPostSelectedUser',compact('GetTrendingPost','GetRepliedComments','PostId'));
    }
    
    public function GetPostStoryForSelectedUser(Request $request)
    {
        $PostId = $request->input('postId');
        $user_id = Session::get('user_id');
        $GetTrendingPost = trending_posts::where('id',$PostId)->get()->toArray();
        $GetRepliedComments = trending_replies::where('trending_post_id',$PostId)->orderBy('replied_date', 'ASC')->get()->toArray();
        return view('trending_post',compact('GetTrendingPost','GetRepliedComments'));
    }
    
    public function GetPeoplesTrendingLikeDetails(Request $request)
    {
        $postId = $request->input('PostId');
        $user_id = Session::get('user_id');
        $GetPeopleLikeDetails = Users::select('users.id','name','profile_picture')->leftJoin('trending_actions', 'users.id', '=', 'trending_actions.from_user_id')->where('trending_actions.post_id',$postId)->where('trending_actions.likes','!=',0)->get()->toArray();
        return view('PeopleLikeDetails',compact('GetPeopleLikeDetails','postId'));
    }
}
?>