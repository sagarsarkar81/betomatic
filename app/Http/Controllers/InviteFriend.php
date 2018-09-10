<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Mail;
use App\user_profiles;
use App\follow_users;
use App\favourite_sports;
use App\favourite_teams;
use App\favourite_players;
use App\albums;
use App\Users;
use App\point_table;
use App\btg_stored_session;

class InviteFriend extends Controller
{
    public function loadPage(){
    	if(Session::get('user_id') == '')
        {
            return redirect(url('login'));
        }else{
            $userId = Session::get('user_id');
            $FetchUserData = Users::where('id',$userId)->get();
            $FollowingData = follow_users::where('from_userid',$userId)->get()->toArray();
            $CountFolowing = count($FollowingData);
            $FollowersData = follow_users::where('to_user_id',$userId)->get()->toArray();
            $CountFollowers = count($FollowersData);
            $Points = point_table::where('user_id',$userId)->get();
            $TotalPoint = 0;
            foreach ($Points as $key => $value) {
            	$TotalPoint += (int)$value->point;
            }
            return view('inviteFriend',compact('FetchUserData','CountFolowing','CountFollowers','Points','TotalPoint'));
        }
    }

    public function sendMail(Request $request){
    	$email = $request->email;
    	$random_number = mt_rand(1,mt_getrandmax());
    	$url = url('check-authentication-of-friend/'.$random_number);
        $data['code'] = $random_number;
        $data['email'] = $email;
        $data['from_user'] = Session::get('user_id');
    	$stored_session = btg_stored_session::where('email',$email)->first();
    	if($stored_session === null){
            btg_stored_session::insert($data);
        }else{
            
            $data['updated_at'] = date('Y-m-d H:i:s');
            $stored_session->fill($data)->save();
        }
    	invite_mail($email,$url);
        return $url;
    }

    public function checkAuthForFriend(Request $request){
    	$randNum = $request->randNos;
        $stored_session = btg_stored_session::where('code',$randNum)->first();
        if($stored_session === null){
             return redirect(url('/'));
        }else{
            $from_user =  $stored_session->from_user;
            UpdatePoints($from_user,10,'Invite Player');
            return redirect(url('/'));
        }
    }


    public function pointForSocialShare(Request $request){
        $value = Session::get('user_id');
        $point_obj = point_table::where('user_id',$value)
                        ->where('reason','like','%Share on social media.%')
                        ->where('date','like','%'.date('Y-m-d').'%')->first();
        if($point_obj === null){
            UpdatePoints($value,1,'Share on social media.');
            echo "success";
        }else{
            echo "unsuccess";
        }
    }
}
