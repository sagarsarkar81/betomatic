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

/**
 * Url from where data should fetch
 *
 * @author Anirban Saha
 * @param  string $url feed url
 * @return ArrayObject array from xml
 */
function getObjectFromXMl($url){
    $xml    =   callCURL($url);
    $obj    =   simplexml_load_string($xml, null, LIBXML_NOCDATA);
    return $obj;
}
/**
 * Url from where data should fetch
 *
 * @author Anirban Saha
 * @param  string $url feed url
 * @return ArrayObject array from xml
 */
function getObjectFromJSON($url)
{
    $json   =   callCURL($url);
    $obj    =   json_decode($json);
    return $obj;
}
/**
 * call cUrl
 *
 * @author Anirban Saha
 * @param  string $url calling url
 * @return mixed      xml/json string
 */
function callCURL($url)
{
    $curl = curl_init($url);
    curl_setopt_array($curl, array(
        CURLOPT_ENCODING => 'gzip', // specify that we accept all supported encoding types
        CURLOPT_RETURNTRANSFER => true
    ));
    $data = curl_exec($curl);
    curl_close($curl);
    if ($data === false) {
        die('Can\'t get data');
    }
    return $data;
}
/**
 *  this will return small loader. you need to show and hide by id
 *
 *  @author Anirban Saha
 *  @return  string  html element of loader
 */
function smallLoader()
{
    return '<i class="loader" id="small_loader" style="display:none;"></i>';
}

function sendDataByCurl($url, $post)
{
    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'X-Application: IDolhrqI0275hGow';
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    $response = curl_exec($ch);

    return json_decode($response);
}

function getDataByCurl($url, $post, $session_token)
{
    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'X-Application: IDolhrqI0275hGow';
    $headers[] = 'X-Authentication:'.$session_token;
    $headers[] = 'Content-Type: application/json';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
    $response = curl_exec($ch);
    return json_decode($response);
}
?>
