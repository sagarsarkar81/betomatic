<?php
use GuzzleHttp\Client;
use App\Users;
use App\cms_email_templates;
use App\btg_user_betting_accounts;
use App\point_table;

date_default_timezone_set("CET");

function aa($x)
{
    echo "<pre>";
    print_r($x);die;
}

function follow_mail($email,$FollowingUserName,$FolloweeUserName)
{
    $GetEmailTemplate = cms_email_templates::where('slug','follow_notification_mail')->get()->toArray();
    if(!empty($GetEmailTemplate))
    {
        $msg = preg_replace("/&#?[a-z0-9]+;/i","",$GetEmailTemplate[0]['content']);
        $msg = str_replace("[user]",$FollowingUserName,$msg);
        $msg = str_replace("[other]",$FolloweeUserName,$msg);
        $data['msg'] = $msg;
        Mail::send('mail_template', $data, function($message) use($email,$GetEmailTemplate){
            $message->to($email)->subject($GetEmailTemplate[0]['subject']);
        });
    }
}
function followee_mail($email,$FollowingUserName,$FolloweeUserName)
{
    $GetEmailTemplate = cms_email_templates::where('slug','follower_notification_mail')->get()->toArray();
    if(!empty($GetEmailTemplate))
    {
        $msg = preg_replace("/&#?[a-z0-9]+;/i","",$GetEmailTemplate[0]['content']);
        $msg = str_replace("[user]",$FolloweeUserName,$msg);
        $msg = str_replace("[other]",$FollowingUserName,$msg);
        $data['msg'] = $msg;
        Mail::send('mail_template', $data, function($message) use($email,$GetEmailTemplate){
            $message->to($email)->subject($GetEmailTemplate[0]['subject']);
        });
    }
}
function comments_mail($email,$CommentedUserName)
{
    $GetEmailTemplate = cms_email_templates::where('slug','comments_received_mail')->get()->toArray();
    if(!empty($GetEmailTemplate))
    {
        $msg = preg_replace("/&#?[a-z0-9]+;/i","",$GetEmailTemplate[0]['content']);
        $msg = str_replace("[user]",$CommentedUserName,$msg);
        $data['msg'] = $msg;
        Mail::send('mail_template', $data, function($message) use($email,$GetEmailTemplate){
            $message->to($email)->subject($GetEmailTemplate[0]['subject']);
        });
    }
}

function invite_mail($email,$url)
{
    //$GetEmailTemplate = cms_email_templates::where('slug','comments_received_mail')->get()->toArray();
    /*if(!empty($GetEmailTemplate))
    {*/
        //$msg = preg_replace("/&#?[a-z0-9]+;/i","",$GetEmailTemplate[0]['content']);
        //$msg = str_replace("[user]",$CommentedUserName,$msg);
        $data['msg'] = "Your invitaion url is ".$url;
        Mail::send('mail_template', $data, function($message) use($email){
            $message->to($email)->subject("Invitaion Mail");
        });
    //}
}

function SetEncodedId($notificationId)
{
    $length = 6;
    $firstStr = "";
    $lastStr = "";

    $characters = array_merge(range('A','M'), range('0','4'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $firstStr .= $characters[$rand];
    }

    $characters = array_merge(range('N','Z'), range('5','9'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $lastStr .= $characters[$rand];
    }
    $notificationString = $firstStr.$notificationId.$lastStr;
    return base64_encode($notificationString);
}

function GetRequestFromAPI($url)
{
    $client = new Client();
    $response = $client->get($url)->getBody();
    $Result = json_decode($response,true);
    return $Result;
}

/*function UpdatePoints($userId,$points)
{
    $GetPoints = btg_user_betting_accounts::select('amount')->where('user_id',$userId)->get()->toArray();
    $data = array('amount'=>($GetPoints[0]['amount'] + $points),
                  'updation_date'=>date("Y-m-d H:i:s")
                  );
    $UpdateQuery = btg_user_betting_accounts::where('user_id',$userId)->update($data);
}*/

function UpdatePoints($userId,$points,$reason)
{
    $GetPoints = btg_user_betting_accounts::select('amount')->where('user_id',$userId)->get()->toArray();
    $data = array('amount'=>($GetPoints[0]['amount'] + $points),
                  'updation_date'=>date("Y-m-d H:i:s")
                  );
    $UpdateQuery = btg_user_betting_accounts::where('user_id',$userId)->update($data);
    $data1['date'] = date('Y-m-d H:i:s');
    $data1['reason'] = $reason;
    $data1['point'] = $points;
    $data1['user_id'] = $userId;
    point_table::insert($data1);
}
?>
