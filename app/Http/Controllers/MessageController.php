<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\follow_users;
use App\Users;
use App\message_sections;
use Carbon\Carbon; 

class MessageController extends Controller
{
    /*public function LoadRegisterHeader(Request $request)
    {
        $user_id = Session::get('user_id');
        $CheckAvailabilityMessage = message_sections::select('receiver_id')->where('receiver_id',$user_id)->get()->toArray();
        return view('common/register_header',compact('CheckAvailabilityMessage'));
    }*/
    /***********Start page load message section************/
    public function MessageIndex()
    {
        if(Session::get('user_id') == '')
        {
            return redirect(url('login'));
        }else{
            Session::forget('FirstuserId');
            $user_id = Session::get('user_id');
            $CheckAvailabilityMessage = message_sections::where('sender_id',$user_id)->get()->toArray();
            $ListOfFriend = array();
            foreach($CheckAvailabilityMessage as $key=>$value)
            {
                $GetNameOfFriends = Users::select('id','name','profile_picture')->where('id',$value['sender_id'])->get()->toArray();
                $Array = array('id'=>$GetNameOfFriends[0]['id'],
                               'name'=>$GetNameOfFriends[0]['name'],
                               'profile_picture'=>$GetNameOfFriends[0]['profile_picture'],
                               'receiver_id'=>$value['receiver_id'],
                               'message_text'=>$value['message_text'],
                               'seen_status'=>$value['seen_status'],
                               'creation_date'=>$value['creation_date'],
                               'updation_date'=>$value['updation_date']
                               );
            
                array_push($ListOfFriend,$Array);
            }
            $GetFriendList = follow_users::distinct('to_user_id')->where('from_userid',$user_id)->get()->toArray();
            return view('message',compact('CheckAvailabilityMessage','ListOfFriend','GetFriendList'));
        }
    }
    /***********End page load message section************/
    /******************Start left side conversation listed user**************/
    public function LeftSideMessageList(Request $request)
    {
        $user_id = Session::get('user_id');
        $GetConversation = DB::select("SELECT DISTINCT `sender_id`,`receiver_id`  FROM `message_sections` WHERE (`sender_id` = ".$user_id."  AND `delete_status` not in (3) AND `deleted_by` != ".$user_id.") OR (`receiver_id` = ".$user_id."  AND `delete_status` not in (3) AND `deleted_by` != ".$user_id.") ORDER BY `creation_date` DESC");
        $GetConversationUser = json_decode(json_encode($GetConversation),true);
        $ReceivedUser = array();
        foreach($GetConversationUser as $key=>$value)
        {
            if(!in_array($value['sender_id'],$ReceivedUser))
            {
                array_push($ReceivedUser,$value['sender_id']);
            }
            if(!in_array($value['receiver_id'],$ReceivedUser))
            {
                array_push($ReceivedUser,$value['receiver_id']);
            }
            if (($key = array_search($user_id, $ReceivedUser)) !== false) {
                unset($ReceivedUser[$key]);
            }
        }
        $ListOfFriend = array();
        foreach($ReceivedUser as $key1=>$value1)
        {
            $GetLastMessageUser = DB::select("SELECT * FROM `message_sections` WHERE `delete_status` not in (3) and `deleted_by` != ".$user_id." AND ((`sender_id`=".$user_id." AND `receiver_id`=".$value1.") OR (`receiver_id`=".$user_id." AND `sender_id`=".$value1.")) ORDER BY `creation_date` DESC LIMIT 1");
            $GetLastMessage = json_decode(json_encode($GetLastMessageUser),true);
            $UserDetails = Users::select('id','name','profile_picture')->where('id',$value1)->get()->toArray();
            $Array = array('id'=>$value1,
                           'name'=>$UserDetails[0]['name'],
                           'profile_picture'=>$UserDetails[0]['profile_picture'],
                           'message_text'=>$GetLastMessage[0]['message_text'],
                           'creation_date'=>$GetLastMessage[0]['creation_date']
                           );
            array_push($ListOfFriend,$Array);
        }
        Session::put('FirstuserId', $ListOfFriend[0]['id']);
        return view('LeftSideMessageList',compact('ListOfFriend'));
    }
    /******************End left side conversation listed user**************/
    /******************Start Chat User**********************/
    public function GetDataForFirstAppearence()
    {
         $sender_user_id = Session::get('user_id');
         $receiver_user_id = Session::get('FirstuserId');
         if(!empty($receiver_user_id))
         {
            $GetMessageDetails = DB::select("SELECT * FROM `message_sections` WHERE (`sender_id`=".$sender_user_id." AND `receiver_id`=".$receiver_user_id." AND `delete_status` not in (3) AND `deleted_by` !=".$sender_user_id.") OR (`receiver_id`=".$sender_user_id." AND `sender_id`=".$receiver_user_id." AND `delete_status` not in (3) AND `deleted_by` !=".$sender_user_id.") ORDER BY `creation_date` ASC");
            $GetMessage = json_decode(json_encode($GetMessageDetails),true);
            return view('ChatUser',compact('GetMessage','sender_user_id','receiver_user_id','Show_label'));
         }
    }
    /******************End Chat User**********************/
    /*****************Start Chatting User Details*****************/
    public function GetChatFirstUserName()
    {
        $receiver_user_id = Session::get('FirstuserId');
        $GetUserName = Users::select('id','name','profile_picture')->where('id',$receiver_user_id)->get()->toArray();
        return view('ChatUserDetails',compact('GetUserName'));
    }
    /*****************End Chatting User Details*****************/
    /*****************When visit on selected user list*****************/
    public function Message(Request $request)
    {
        $user_id = Session::get('user_id');
        $SelectedUserId = $request->input('SelectedUserId');
        $GetFriendDetails = Users::select('id','name','profile_picture')->where('id',$SelectedUserId)->get()->toArray();
        $ListOfFriend = array();
        foreach($GetFriendDetails as $key=>$value)
        {
            $GetPeopleFromLeftSideList = DB::select("SELECT * FROM `message_sections` WHERE ((`sender_id` = ".$user_id." AND `receiver_id` = ".$value['id'].") OR (`receiver_id` = ".$user_id."  AND `sender_id` = ".$value['id'].")) AND `delete_status` NOT IN (3) AND `deleted_by` != ".$user_id." ORDER BY `creation_date` DESC LIMIT 1");
            $GetPeopleFromList = json_decode(json_encode($GetPeopleFromLeftSideList),true);
            $Array = array('id'=>$value['id'],
                           'name'=>$value['name'],
                           'profile_picture'=>$value['profile_picture'],
                           'receiver_id'=>$GetPeopleFromList[0]['receiver_id'],
                           'message_text'=>$GetPeopleFromList[0]['message_text'],
                           'seen_status'=>$GetPeopleFromList[0]['seen_status'],
                           'creation_date'=>$GetPeopleFromList[0]['creation_date'],
                           'updation_date'=>$GetPeopleFromList[0]['updation_date']
                           );
            array_push($ListOfFriend,$Array);
        }
        return view('LeftSideMessageList',compact('ListOfFriend'));
    }
    /*****************End When visit on selected user list*****************/
    /*****************Get chat details for visit on selected user list*****************/
    public function GetChatWithFriend(Request $request)
    {
        $sender_user_id = Session::get('user_id');
        $receiver_user_id = $request->input('SelectedUserId');
        $GetMessageDetails = DB::select("SELECT * FROM `message_sections` WHERE ((`sender_id` = ".$sender_user_id." AND `receiver_id` = ".$receiver_user_id.") OR (`receiver_id` = ".$sender_user_id."  AND `sender_id` = ".$receiver_user_id.")) AND `delete_status` NOT IN (3) AND `deleted_by` != ".$sender_user_id." ORDER BY `creation_date` ASC");
        $GetMessage = json_decode(json_encode($GetMessageDetails),true);
        return view('ChatUser',compact('GetMessage','sender_user_id','receiver_user_id'));
    }
    /*****************End Get chat details for visit on selected user list*****************/
    public function GetFriendDetails(Request $request)
    {
        $receiver_user_id = $request->input('SelectedUserId');
        $GetUserName = Users::select('id','name','profile_picture')->where('id',$receiver_user_id)->get()->toArray();
        return view('ChatUserDetails',compact('GetUserName'));
    }    
    //-----------------------------------------------------------//
    public function ChatBetweenUser(Request $request)
    {
        $sender_user_id = Session::get('user_id');
        $receiver_user_id = $request->input('receiver_user_id');
        $message = $request->input('message');
        $data = array('sender_id'=>$sender_user_id,
                      'receiver_id'=>$receiver_user_id,
                      'message_text'=>$message,
                      'seen_status'=>0,
                      'deleted_by'=>0,
                      'delete_status'=>0,
                      'creation_date'=>date("Y-m-d H:i:s"),
                      'updation_date'=>date("Y-m-d H:i:s")
                      );
        $InsertData = message_sections::insert($data);
        $GetMessageDetails = DB::select("SELECT * FROM `message_sections` WHERE ((`sender_id` = ".$sender_user_id." AND `receiver_id` = ".$receiver_user_id.") OR (`receiver_id` = ".$sender_user_id."  AND `sender_id` = ".$receiver_user_id.")) AND `delete_status` NOT IN (3) AND `deleted_by` != ".$sender_user_id." ORDER BY `creation_date` DESC LIMIT 1");
        $GetMessage = json_decode(json_encode($GetMessageDetails),true);
        return view('ChatUser',compact('GetMessage','sender_user_id','receiver_user_id'));
    }
    
    public function LoadChatDetails(Request $request)
    {
        $sender_user_id = Session::get('user_id');
        $receiver_user_id = $request->input('receiver_user_id');
        $GetMessageDetails = DB::select("SELECT * FROM `message_sections` WHERE ((`sender_id` = ".$sender_user_id." AND `receiver_id` = ".$receiver_user_id.") OR (`receiver_id` = ".$sender_user_id."  AND `sender_id` = ".$receiver_user_id.")) AND `delete_status` NOT IN (3) AND `deleted_by` != ".$sender_user_id." ORDER BY `creation_date` ASC");
        $GetMessage = json_decode(json_encode($GetMessageDetails),true);
        return view('ChatUser',compact('GetMessage','sender_user_id','receiver_user_id'));
    }
    
    public function SearchPeopleFromList(Request $request)
    {
        $sender_user_id = Session::get('user_id');
        $UserName = $request->input('username');
        $SearchPeopleId = Users::select('id','name','profile_picture')->where('name','like',$UserName.'%')->where('id','!=',$sender_user_id)->get()->toArray();
        $ListOfFriend = array();
        foreach($SearchPeopleId as $keyId=>$ValueId)
        {
            $GetPeopleFromLeftList = DB::select("SELECT * FROM `message_sections` WHERE ((`receiver_id`=".$ValueId['id']." AND `sender_id`=".$sender_user_id.") OR (`receiver_id`=".$sender_user_id." AND `sender_id`=".$ValueId['id'].")) AND `delete_status` NOT IN (3) AND `deleted_by` != ".$sender_user_id." ORDER BY `creation_date` DESC");
            //$GetPeopleFromLeftList = DB::select("SELECT * FROM `message_sections` WHERE ((`receiver_id` IN (".$Array_implode.") AND `sender_id`=".$sender_user_id.") OR (`receiver_id`=".$sender_user_id." AND `sender_id` IN (".$Array_implode."))) AND `delete_status` NOT IN (3) AND `deleted_by` != ".$sender_user_id." ORDER BY `creation_date` DESC");
            $GetPeopleFromList = json_decode(json_encode($GetPeopleFromLeftList),true);
            if(!empty($GetPeopleFromList))
            {
                $Array = array('id'=>$ValueId['id'],
                           'name'=>$ValueId['name'],
                           'profile_picture'=>$ValueId['profile_picture'],
                           'receiver_id'=>$GetPeopleFromList[0]['receiver_id'],
                           'message_text'=>$GetPeopleFromList[0]['message_text'],
                           'seen_status'=>$GetPeopleFromList[0]['seen_status'],
                           'creation_date'=>$GetPeopleFromList[0]['creation_date'],
                           'updation_date'=>$GetPeopleFromList[0]['updation_date']
                           );
                array_push($ListOfFriend,$Array);
            }
        }
        return view('LeftSideMessageList',compact('ListOfFriend'));
    }
    
    public function LoadUserDetails(Request $request)
    {
        $sender_user_id = Session::get('user_id');
        $receiver_user_id = $request->input('receiver_user_id');
        $GetUserName = Users::select('id','name','profile_picture')->where('id',$receiver_user_id)->get()->toArray();
        return view('ChatUserDetails',compact('GetUserName'));
    }
    
    public function SearchFriend(Request $request)
    {
        $UserName = $request->input('username');
        $user_id = Session::get('user_id');
        $GetFriendList = Users::select('id','name','profile_picture')->where('name','like',''.$UserName.'%')->where('id','!=',$user_id)->get()->toArray();
        return view('FriendList',compact('GetFriendList'));
    }
    
    public function UnreadMessageNotification()
    {
        $sender_user_id = Session::get('user_id');
        $GetUnreadMessage = message_sections::where('receiver_id',$sender_user_id)->where('seen_status','0')->where('delete_status','!=',3)->orderBy('creation_date','DESC')->get()->toArray();
        $CountUnreadMessage = count($GetUnreadMessage);
        echo $CountUnreadMessage;
    }
    
    public function GetDetailMessageNotification()
    {
        $user_id = Session::get('user_id');
        $GetConversation = DB::select("SELECT DISTINCT `sender_id`,`receiver_id`  FROM `message_sections` WHERE (`sender_id` = ".$user_id."  AND `delete_status` not in (3) AND `deleted_by` != ".$user_id.") OR (`receiver_id` = ".$user_id."  AND `delete_status` not in (3) AND `deleted_by` != ".$user_id.") ORDER BY `creation_date` DESC");
        $GetConversationUser = json_decode(json_encode($GetConversation),true);
        $ReceivedUser = array();
        foreach($GetConversationUser as $key=>$value)
        {
            if(!in_array($value['sender_id'],$ReceivedUser))
            {
                array_push($ReceivedUser,$value['sender_id']);
            }
            if(!in_array($value['receiver_id'],$ReceivedUser))
            {
                array_push($ReceivedUser,$value['receiver_id']);
            }
            if (($key = array_search($user_id, $ReceivedUser)) !== false) {
                unset($ReceivedUser[$key]);
            }
        }
        $ListOfFriend = array();
        foreach($ReceivedUser as $key1=>$value1)
        {
            $GetLastMessageUser = DB::select("SELECT * FROM `message_sections` WHERE `delete_status` not in (3) and `deleted_by` != ".$user_id." AND ((`sender_id`=".$user_id." AND `receiver_id`=".$value1.") OR (`receiver_id`=".$user_id." AND `sender_id`=".$value1.")) ORDER BY `creation_date` DESC LIMIT 1");
            $GetLastMessage = json_decode(json_encode($GetLastMessageUser),true);
            $UserDetails = Users::select('id','name','profile_picture')->where('id',$value1)->get()->toArray();
            $Array = array('id'=>$value1,
                           'name'=>$UserDetails[0]['name'],
                           'profile_picture'=>$UserDetails[0]['profile_picture'],
                           'message_text'=>$GetLastMessage[0]['message_text'],
                           'creation_date'=>$GetLastMessage[0]['creation_date']
                           );
            array_push($ListOfFriend,$Array);
            /*********update message seen status**********************/
            $UpdateData = array('seen_status'=>1,'updation_date'=>date("Y-m-d H:i:s"));
            $GetStatus = message_sections::where('sender_id',$value1)->where('receiver_id',$user_id)->where('seen_status',0)->update($UpdateData);
            /*********update message seen status**********************/
        }
        /*****************************************************************/
        return view('message_notification',compact('ListOfFriend'));
    }
    
    public function VisitMessagePage($EncryptedId)
    {
        $user_id = Session::get('user_id');
        $decodedUrl = base64_decode($EncryptedId);
        $id = substr($decodedUrl, 6, -6);
        $GetMessageDetails = DB::select("SELECT * FROM `message_sections` WHERE (`sender_id`=".$user_id." AND `receiver_id`=".$id." AND `delete_status` not in (3) AND `deleted_by` !=".$user_id.") OR (`receiver_id`=".$user_id." AND `sender_id`=".$id." AND `delete_status` not in (3) AND `deleted_by` !=".$user_id.")");
        $CheckAvailabilityMessage = json_decode(json_encode($GetMessageDetails),true);
        $ListOfFriend = array();
        foreach($CheckAvailabilityMessage as $key=>$value)
        {
            $GetNameOfFriends = Users::select('id','name','profile_picture')->where('id',$id)->get()->toArray();
            $Array = array('id'=>$GetNameOfFriends[0]['id'],
                           'name'=>$GetNameOfFriends[0]['name'],
                           'profile_picture'=>$GetNameOfFriends[0]['profile_picture'],
                           'message_text'=>$value['message_text'],
                           'creation_date'=>$value['creation_date']
                          );
        
            array_push($ListOfFriend,$Array);
        }
        $GetFriendList = follow_users::distinct('to_user_id')->where('from_userid',$user_id)->get()->toArray();
        return view('message2',compact('ListOfFriend','GetFriendList','id'));
    }
    
    public function GetOtherConversations(Request $request)
    {
        $user_id = Session::get('user_id');
        $SelectedUserId = $request->input('SelectedUserId');
        $GetConversation = DB::select("SELECT DISTINCT `sender_id`,`receiver_id`  FROM `message_sections` WHERE (`sender_id` = ".$user_id."  AND `delete_status` NOT IN (3) AND `deleted_by` != ".$user_id.") OR (`receiver_id` = ".$user_id."  AND `delete_status` NOT IN (3) AND `deleted_by` != ".$user_id.") ORDER BY `creation_date` DESC");
        $GetConversationUser = json_decode(json_encode($GetConversation),true);
        $ReceivedUser = array();
        foreach($GetConversationUser as $key=>$value)
        {
            if(!in_array($value['sender_id'],$ReceivedUser))
            {
                array_push($ReceivedUser,$value['sender_id']);
            }
            if(!in_array($value['receiver_id'],$ReceivedUser))
            {
                array_push($ReceivedUser,$value['receiver_id']);
            }
            if (($key = array_search($user_id, $ReceivedUser)) !== false) {
                unset($ReceivedUser[$key]);
            }
            if (($key = array_search($SelectedUserId, $ReceivedUser)) !== false) {
                unset($ReceivedUser[$key]);
            }
        }
        $ListOfFriend = array();
        foreach($ReceivedUser as $key1=>$value1)
        {
            $GetLastMessageUser = DB::select("SELECT * FROM `message_sections` WHERE `delete_status` not in (3) and `deleted_by` not in (".$user_id.") AND ((`sender_id`=".$user_id." AND `receiver_id`=".$value1.") OR (`receiver_id`=".$user_id." AND `sender_id`=".$value1.")) ORDER BY `creation_date` DESC LIMIT 1");
            $GetLastMessage = json_decode(json_encode($GetLastMessageUser),true);
            $UserDetails = Users::select('id','name','profile_picture')->where('id',$value1)->get()->toArray();
            $Array = array('id'=>$value1,
                           'name'=>$UserDetails[0]['name'],
                           'profile_picture'=>$UserDetails[0]['profile_picture'],
                           'message_text'=>$GetLastMessage[0]['message_text'],
                           'creation_date'=>$GetLastMessage[0]['creation_date']
                           );
            array_push($ListOfFriend,$Array);
        }
        if(!empty($ListOfFriend))
        {
            return view('LeftSideMessageList',compact('ListOfFriend'));
        }
        
    }
    /************************************Delete Entire Conversations************************/
    public function DeleteEntireConversations(Request $request)
    {
        $user_id = Session::get('user_id');
        $SelectedUserId = $request->input('SelectedUserId');
        $CheckDeletedUserChat = DB::select("SELECT * FROM `message_sections` WHERE ((`sender_id`=".$user_id." AND `receiver_id`=".$SelectedUserId.") OR (`sender_id`=".$SelectedUserId." AND `receiver_id`=".$user_id."))");
        $CheckDeletedUser = json_decode(json_encode($CheckDeletedUserChat),true);
        //echo "<pre>";
        //print_r($CheckDeletedUser);die;
        foreach($CheckDeletedUser as $key=>$value)
        {
            if($value['delete_status'] == 0)
            {
                $DeleteEntireConversations = DB::select("UPDATE `message_sections` SET `deleted_by` = ".$user_id.",`delete_status` = 1 WHERE ((`sender_id`=".$user_id." AND `receiver_id`=".$SelectedUserId." AND `delete_status` = 0) OR (`receiver_id`=".$user_id." AND `sender_id`=".$SelectedUserId." AND `delete_status` = 0))");
            }elseif($value['delete_status'] == 2 && $value['deleted_by'] != $user_id){
                $DeleteEntireConversations = DB::select("UPDATE `message_sections` SET `deleted_by` = ".$user_id.",`delete_status` = 3 WHERE ((`sender_id`=".$user_id." AND `receiver_id`=".$SelectedUserId." AND `delete_status` = 2 AND `deleted_by` !=".$user_id.") OR (`receiver_id`=".$user_id." AND `sender_id`=".$SelectedUserId." AND `delete_status` = 2 AND `deleted_by` !=".$user_id."))");
            }elseif($value['delete_status'] == 1){
                $DeleteEntireConversations = DB::select("DELETE FROM `message_sections` WHERE ((`sender_id`=".$user_id." AND `receiver_id`=".$SelectedUserId." AND `delete_status`=1) OR (`sender_id`=".$SelectedUserId." AND `receiver_id`=".$user_id." AND `delete_status`=1))");
            }elseif($value['delete_status'] == 3){
                $DeleteEntireConversations = DB::select("DELETE FROM `message_sections` WHERE ((`sender_id`=".$user_id." AND `receiver_id`=".$SelectedUserId." AND `delete_status`=3) OR (`sender_id`=".$SelectedUserId." AND `receiver_id`=".$user_id." AND `delete_status`=3))");
            }
        }
    }
    /****************************Individual chat details*********************************/
    public function DeleteIndividualChat(Request $request)
    {
        $sender_user_id =  Session::get('user_id');
        $receiver_user_id = $request->input('ReceiverUserId');
        $SelectdChatId = $request->input('ChatId');
        $SelectedId = implode(",",$SelectdChatId);
        $CheckDeleteStatusUser = DB::select("SELECT * FROM `message_sections` WHERE `id` IN (".$SelectedId.")");
        $CheckDeleteStatus = json_decode(json_encode($CheckDeleteStatusUser),true);
        foreach($CheckDeleteStatus as $key=>$value)
        {
            if($value['delete_status'] == 0)
            {
                $data = array('deleted_by'=>$sender_user_id,
                              'delete_status'=>2,
                              'updation_date'=>date("Y-m-d H:i:s")
                             );
                $UpdateQuery = message_sections::where('id',$value['id'])->update($data);
            
            }elseif($value['delete_status'] == 2){
                $data = array('deleted_by'=>$sender_user_id,
                              'delete_status'=>3,
                              'updation_date'=>date("Y-m-d H:i:s")
                             );
                $UpdateQuery = message_sections::where('id',$value['id'])->update($data);
                
            }elseif($value['delete_status'] == 1){
                $data = array('deleted_by'=>$sender_user_id,
                              'delete_status'=>3,
                              'updation_date'=>date("Y-m-d H:i:s")
                             );
                $UpdateQuery = message_sections::where('id',$value['id'])->update($data);
                
            }
        }
        $GetMessageAfterDelete = DB::select("SELECT * FROM `message_sections` WHERE (`sender_id`=".$sender_user_id." AND `receiver_id`=".$receiver_user_id." AND `delete_status` not in (1,2) and `deleted_by` !=".$sender_user_id.") OR (`receiver_id`=".$sender_user_id." AND `sender_id`=".$receiver_user_id." AND `delete_status` not in (1,2) AND `deleted_by` !=".$sender_user_id.") ORDER BY `creation_date` ASC");
        $GetMessage = json_decode(json_encode($GetMessageAfterDelete),true);
        return view('ChatUser',compact('GetMessage','sender_user_id','receiver_user_id'));
    }
}
?>