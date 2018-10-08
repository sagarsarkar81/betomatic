<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\UrlGenerator;
use App\Users;
use App\Countries;
use App\Country_codes;
use App\timezones;
use App\edit_profile_settings;
use App\cms_email_templates;
use App\user_profiles;
use App\follow_users;
use App\favourite_sports;
use App\favourite_teams;
use App\favourite_players;
use App\albums;
use App\photo_albums;
use App\notifications;
use Session;
use Mail;
class ProfileController extends Controller
{
    
    function GetSelectedTab($SelectedTab)
    {
        echo $SelectedTab;
        //return $SelectedTab;
    }
    
    
    public function index()
    {
        if(Session::get('user_id') == '')
        {
            return redirect(url('login'));
        }else{
            //date_default_timezone_set("Asia/Calcutta");
            //echo date("Y-m-d H:i:s");die;
            $userId = Session::get('user_id');
            $FetchUserData = Users::where('id',$userId)->get();
            $FetchProfileData = user_profiles::where('user_id',$userId)->get()->toArray();
            $FollowingData = follow_users::where('from_userid',$userId)->get()->toArray();
            $CountFolowing = count($FollowingData);
            $FollowersData = follow_users::where('to_user_id',$userId)->get()->toArray();
            $CountFollowers = count($FollowersData);
            $GetSportsDetails = favourite_sports::select('id','sports_name','sports_image')->get()->toArray();
            $GetTeamsDetails = favourite_teams::select('id','sports_id','team_name','team_pics')->get()->toArray();
            $GetPlayersDetails = favourite_players::select('id','sports_id','team_id','players_name','players_image')->get()->toArray();
            
            $GetAlbum = albums::where('user_id',$userId)->get()->toArray();
            //echo $this->GetSelectedTab();die;
            //echo "<pre>";
            //print_r($GetAlbumImage);die;
            return view('profile',compact('FetchUserData','FetchProfileData','CountFolowing','CountFollowers','GetSportsDetails','GetTeamsDetails','GetPlayersDetails','GetAlbum'));
        }
    }
    
    public function FollowFollowing(Request $request)
    {
        if(Session::get('user_id') == '')
        {
            return redirect(url('login'));
        }
        else{
            $userId = Session::get('user_id');
            $FetchUserData = Users::where('status',1)->get()->toArray();
            $FollowersData = follow_users::where('to_user_id',$userId)->get()->toArray();
            return view('followfollowing',compact('FetchUserData','FollowersData'));
        }
    }
    /****notification status change********/
    public function FollowFollowingNotification($EncryptedId)
    {
        $decodedUrl = base64_decode($EncryptedId);
        $NotificationId = substr($decodedUrl, 6, -6);
        $UpdateArray = array('detail_seen_status'=>1,'updation_date'=>date("Y-m-d H:i:s"));
        $UpdateQuery = notifications::where('id',$NotificationId)->update($UpdateArray);
        $userId = Session::get('user_id');
        $FetchUserData = Users::where('status',1)->get()->toArray();
        $FollowersData = follow_users::where('to_user_id',$userId)->get()->toArray();
        return view('followfollowing',compact('FetchUserData','FollowersData'));
        
    }
    /****notification status change********/
    public function VisitorsFollowFollowing(Request $request,$VisitorUserId)
    {
        if(Session::get('user_id') == '')
        {
            return redirect(url('login'));
        }
        else{
            $userId = Session::get('user_id');
            $FetchUserData = Users::where('status',1)->get()->toArray();
            $FollowersData = follow_users::where('to_user_id',$VisitorUserId)->get()->toArray();
            return view('Visitorsfollowfollowing',compact('FetchUserData','FollowersData','VisitorUserId'));
        }
    }
    
    public function FollowingUser(Request $request)
    {
        $FolloweeUserId = Session::get('user_id');
        $FollwingUserId = $request->input('FollowingUserId');
        $FollwingUserName = $request->input('FollowingUserName');
        $data = array('from_userid'=>$FolloweeUserId,
                      'to_user_id'=>$FollwingUserId,
                      'status'=>1,
                      'creation_date' => date("Y-m-d H:i:s"),
                      'updation_date' => date("Y-m-d H:i:s")
                      );
        $CheckFollowed = follow_users::where('from_userid',$FolloweeUserId)->where('to_user_id',$FollwingUserId)->get()->toArray();
        if(empty($CheckFollowed))
        {
            $InsertQuery = follow_users::insert($data);
            /**********Email notification*********/
            /*$FollowingUserEmailId = Users::select('name','email')->where('id',$FolloweeUserId)->get()->toArray();//----get emaild whoom user following
            $FolloweeUserEmailId = Users::select('name','email')->where('id',$FollwingUserId)->get()->toArray();//----get emaild user who following other
            $CheckNotificationForFollowee = edit_profile_settings::select('user_id','follow')->where('user_id',$FolloweeUserId)->get()->toArray();
            if(!empty($CheckNotificationForFollowee))
            {
                if($CheckNotificationForFollowee[0]['follow'] == 1)
                {
                    follow_mail($FollowingUserEmailId[0]['email'],$FollowingUserEmailId[0]['name'],$FolloweeUserEmailId[0]['name']);
                }
            }
            $CheckNotificationForFollowing = edit_profile_settings::select('user_id','follow')->where('user_id',$FollwingUserId)->get()->toArray();
            if(!empty($CheckNotificationForFollowing))
            {
                if($CheckNotificationForFollowing[0]['follow'] == 1)
                {
                    followee_mail($FolloweeUserEmailId[0]['email'],$FollowingUserEmailId[0]['name'],$FolloweeUserEmailId[0]['name']);
                }
            }*/
            /*************************************/
            /************Notification for follow*****************/
            $GetNameOfFromUser =  Users::select('name')->where('id',$FolloweeUserId)->get()->toArray();
            $GetNameOfToUser =  Users::select('name')->where('id',$FollwingUserId)->get()->toArray();
            $data = array('from_userid'=>$FolloweeUserId,
                          'to_userid'=>$FollwingUserId,
                          'text'=>$GetNameOfFromUser[0]['name'].' is started following you',
                          'incident_type'=>'Follow',
                          'incident_id'=>0,
                          'status'=>0,
                          'detail_seen_status'=>0,
                          'creation_date'=>date("Y-m-d H:i:s"),
                          'updation_date' => date("Y-m-d H:i:s")
                          );
            $GenerateNotification = notifications::insert($data);
            /***************************************************/
            if($InsertQuery == true)
            {
                echo "follow";
            }
        }else{
            $DeleteQuery = follow_users::where('from_userid',$FolloweeUserId)->where('to_user_id',$FollwingUserId)->delete();
            if($DeleteQuery == true)
            {
                echo "Unfollow";
            }
        }
    }
    
    public function UpdateFavouriteSports(Request $request)
    {
        $UserId = Session::get('user_id');
        $SelectedTab = $request->input('FavouriteSports');
        $FavouriteSports = $request->input('sports');
        $data = array('user_id'=>$UserId,'favourite_sports'=>json_encode($FavouriteSports),'creation_date'=>date("Y-m-d H:i:s"),'updation_date'=>date("Y-m-d H:i:s"));
        $CheckUserExist = user_profiles::select('favourite_sports')->where('user_id',$UserId)->get()->toArray();
        if(empty($CheckUserExist))
        {
            $InsertQuery = user_profiles::insert($data);
        }else{
            $UpdateQuery = user_profiles::where('user_id',$UserId)->update($data);
        }
        $request->session()->flash('success', 'Favourite sports updated');
        $request->session()->flash('Sports', 'User Sports Tab');
        return redirect(url('profile'));
        //return view('profile',compact('SelectedTab'));
    }
    
    public function UpdateFavouriteTeamPlayer(Request $request)
    {
        $UserId = Session::get('user_id');
        $FavouriteTeams = $request->input('teams');
        $FavouritePlayers = $request->input('players');
        $GetTeamFromSession = Session::get('team');
        $CheckUserExist = user_profiles::select('favourite_sports')->where('user_id',$UserId)->get()->toArray();
        $data = array('user_id'=>$UserId,'favourite_teams'=>json_encode($FavouriteTeams),'favourite_players'=>json_encode($FavouritePlayers),'creation_date'=>date("Y-m-d H:i:s"),'updation_date'=>date("Y-m-d H:i:s"));
        if(empty($CheckUserExist))
        {
            $InsertQuery = user_profiles::insert($data);
        }else{
            $UpdateQuery = user_profiles::where('user_id',$UserId)->update($data);
        }
        $request->session()->flash('success', 'Favourite teams and players updated');
        $request->session()->flash('Players', 'User Players Tab');
        return redirect(url('profile'));
    }
    
    public function UploadAlbum(Request $request)
    {
        $ImageArray = array();
        if ($request->hasFile('file')) 
        {
            $destinationPath = public_path('assets/front_end/images/album');
            $files = $request->file('file'); // will get all files
            foreach ($files as $file) {//this statement will loop through all files.
                $file_name = $file->getClientOriginalName(); //Get file original name
                $file->move($destinationPath , $file_name); // move files to destination folder
                array_push($ImageArray,$file_name);
                
            }
            Session::put('image', $ImageArray);
            $GetSessionData = Session::get('image');
            //echo "<pre>";
            //print_r($GetSessionData);
            
        }
    }
    
    public function SubmitAlbumData(Request $request)
    {
        $SelectedTab = $request->input('SelectedTab');
        $AlbumName = $request->input('AlbumName');
        $UserId = Session::get('user_id');
        $data = array('user_id'=>$UserId,
                      'album_description'=>$AlbumName,
                      'creation_date'=>date("Y-m-d H:i:s"),
                      'updation_date'=>date("Y-m-d H:i:s")
                      );
        $InsertQuery = albums::insert($data);
        //$lastInsertedId = $InsertQuery->id;
        $GetAlbumId = albums::select('id')->where('user_id',$UserId)->orderBy('id', 'DESC')->limit(1)->get()->toArray();
        $GetSessionData = Session::get('image');
        foreach($GetSessionData as $SessionValue)
        {
            $SecondData = array('album_id'=>$GetAlbumId[0][id],
                          'user_id'=>$UserId,
                          'images'=>$SessionValue,
                          'creation_date'=>date("Y-m-d H:i:s"),
                          'updation_date'=>date("Y-m-d H:i:s")
                          );
            $SecondInsertQuery = photo_albums::insert($SecondData);
        }
        Session::forget('image');
        $request->session()->flash('success', 'Album Created');
        $request->session()->flash('Photos', 'Photos Tab');
        echo "success";
    }
    
    public function SubmitAlbumData2(Request $request)
    {
        $SelectedTab = $request->input('SelectedTab');
        $AlbumId = $request->input('albumId');
        $UserId = Session::get('user_id');
        $GetSessionData = Session::get('image');
        foreach($GetSessionData as $SessionValue)
        {
            $Data = array('album_id'=>$AlbumId,
                          'user_id'=>$UserId,
                          'images'=>$SessionValue,
                          'creation_date'=>date("Y-m-d H:i:s"),
                          'updation_date'=>date("Y-m-d H:i:s")
                          );
            $SecondInsertQuery = photo_albums::insert($Data);
        }
        Session::forget('image');
        $request->session()->flash('success', 'Album Created');
        $request->session()->flash('Photos', 'Photos Tab');
        echo "success";
    }
    
    public function EditAlbum(Request $request)
    {
        $UserId = $request->input('UserId');
        $AlbumId = $request->input('AlbumId');
    }
    
    public function EditAlbumName(Request $request)
    {
        $UserId = Session::get('user_id');
        $AlbumName = $request->input('EditAlbumName');
        $AlbumId = $request->input('albumId');
        $SelectedImageId = $request->input('checkbox');
        //echo $AlbumName;echo "<br>";
        //echo $AlbumId;echo "<br>";
        //print_r($SelectedImageId);
        if(!empty($AlbumName))
        {
            $data = array('album_description'=>$AlbumName);
            $UpdateALbumName = albums::where('user_id',$UserId)->where('id',$AlbumId)->update($data);
        }
        if(!empty($SelectedImageId))
        {
            foreach($SelectedImageId as $ImageValue)
            {
                $UpdatePhotoAlbum = photo_albums::where('user_id',$UserId)->where('id',$ImageValue)->delete();
                //echo "<pre>";
                //print_r($UpdatePhotoAlbum);
            }
            $request->session()->flash('success', 'Album updated');
            $request->session()->flash('Photos', 'Photos Tab');
        }
        return redirect(url('profile'));
        
    }
    
    public function DeleteAlbum(Request $request)
    {
        //$SelectedTab = $request->input('SelectedTab');
        $UserId = Session::get('user_id');
        $AlbumId = $request->input('AlbumId');
        $DeleteAlbum = albums::where('user_id',$UserId)->where('id',$AlbumId)->delete();
        $DeleteImages = photo_albums::where('user_id',$UserId)->where('album_id',$AlbumId)->delete();
        //$request->session()->flash('success', 'Album successfully deleted');
        $request->session()->flash('Photos', 'Photos Tab');
        echo "success";
    }
}
?>