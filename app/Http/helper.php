<?php
use GuzzleHttp\Client;
use App\Users;
use App\cms_email_templates;
use App\btg_user_betting_accounts;
use App\point_table;
use App\Http\Controller\Auth\LoginController;
use Session;
use Illuminate\Http\Request;

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

function countryCodeToCountry($code) {
    $code = strtoupper($code);
    if ($code == 'AF') return 'Afghanistan';
    if ($code == 'AX') return 'Aland Islands';
    if ($code == 'AL') return 'Albania';
    if ($code == 'DZ') return 'Algeria';
    if ($code == 'AS') return 'American Samoa';
    if ($code == 'AD') return 'Andorra';
    if ($code == 'AO') return 'Angola';
    if ($code == 'AI') return 'Anguilla';
    if ($code == 'AQ') return 'Antarctica';
    if ($code == 'AG') return 'Antigua and Barbuda';
    if ($code == 'AR') return 'Argentina';
    if ($code == 'AM') return 'Armenia';
    if ($code == 'AW') return 'Aruba';
    if ($code == 'AU') return 'Australia';
    if ($code == 'AT') return 'Austria';
    if ($code == 'AZ') return 'Azerbaijan';
    if ($code == 'BS') return 'Bahamas the';
    if ($code == 'BH') return 'Bahrain';
    if ($code == 'BD') return 'Bangladesh';
    if ($code == 'BB') return 'Barbados';
    if ($code == 'BY') return 'Belarus';
    if ($code == 'BE') return 'Belgium';
    if ($code == 'BZ') return 'Belize';
    if ($code == 'BJ') return 'Benin';
    if ($code == 'BM') return 'Bermuda';
    if ($code == 'BT') return 'Bhutan';
    if ($code == 'BO') return 'Bolivia';
    if ($code == 'BA') return 'Bosnia and Herzegovina';
    if ($code == 'BW') return 'Botswana';
    if ($code == 'BV') return 'Bouvet Island (Bouvetoya)';
    if ($code == 'BR') return 'Brazil';
    if ($code == 'IO') return 'British Indian Ocean Territory (Chagos Archipelago)';
    if ($code == 'VG') return 'British Virgin Islands';
    if ($code == 'BN') return 'Brunei Darussalam';
    if ($code == 'BG') return 'Bulgaria';
    if ($code == 'BF') return 'Burkina Faso';
    if ($code == 'BI') return 'Burundi';
    if ($code == 'KH') return 'Cambodia';
    if ($code == 'CM') return 'Cameroon';
    if ($code == 'CA') return 'Canada';
    if ($code == 'CV') return 'Cape Verde';
    if ($code == 'KY') return 'Cayman Islands';
    if ($code == 'CF') return 'Central African Republic';
    if ($code == 'TD') return 'Chad';
    if ($code == 'CL') return 'Chile';
    if ($code == 'CN') return 'China';
    if ($code == 'CX') return 'Christmas Island';
    if ($code == 'CC') return 'Cocos (Keeling) Islands';
    if ($code == 'CO') return 'Colombia';
    if ($code == 'KM') return 'Comoros the';
    if ($code == 'CD') return 'Congo';
    if ($code == 'CG') return 'Congo the';
    if ($code == 'CK') return 'Cook Islands';
    if ($code == 'CR') return 'Costa Rica';
    if ($code == 'CI') return 'Cote d\'Ivoire';
    if ($code == 'HR') return 'Croatia';
    if ($code == 'CU') return 'Cuba';
    if ($code == 'CY') return 'Cyprus';
    if ($code == 'CZ') return 'Czech Republic';
    if ($code == 'DK') return 'Denmark';
    if ($code == 'DJ') return 'Djibouti';
    if ($code == 'DM') return 'Dominica';
    if ($code == 'DO') return 'Dominican Republic';
    if ($code == 'EC') return 'Ecuador';
    if ($code == 'EG') return 'Egypt';
    if ($code == 'SV') return 'El Salvador';
    if ($code == 'GQ') return 'Equatorial Guinea';
    if ($code == 'ER') return 'Eritrea';
    if ($code == 'EE') return 'Estonia';
    if ($code == 'ET') return 'Ethiopia';
    if ($code == 'FO') return 'Faroe Islands';
    if ($code == 'FK') return 'Falkland Islands (Malvinas)';
    if ($code == 'FJ') return 'Fiji the Fiji Islands';
    if ($code == 'FI') return 'Finland';
    if ($code == 'FR') return 'France, French Republic';
    if ($code == 'GF') return 'French Guiana';
    if ($code == 'PF') return 'French Polynesia';
    if ($code == 'TF') return 'French Southern Territories';
    if ($code == 'GA') return 'Gabon';
    if ($code == 'GM') return 'Gambia the';
    if ($code == 'GE') return 'Georgia';
    if ($code == 'DE') return 'Germany';
    if ($code == 'GH') return 'Ghana';
    if ($code == 'GI') return 'Gibraltar';
    if ($code == 'GR') return 'Greece';
    if ($code == 'GL') return 'Greenland';
    if ($code == 'GD') return 'Grenada';
    if ($code == 'GP') return 'Guadeloupe';
    if ($code == 'GU') return 'Guam';
    if ($code == 'GT') return 'Guatemala';
    if ($code == 'GG') return 'Guernsey';
    if ($code == 'GN') return 'Guinea';
    if ($code == 'GW') return 'Guinea-Bissau';
    if ($code == 'GY') return 'Guyana';
    if ($code == 'HT') return 'Haiti';
    if ($code == 'HM') return 'Heard Island and McDonald Islands';
    if ($code == 'VA') return 'Holy See (Vatican City State)';
    if ($code == 'HN') return 'Honduras';
    if ($code == 'HK') return 'Hong Kong';
    if ($code == 'HU') return 'Hungary';
    if ($code == 'IS') return 'Iceland';
    if ($code == 'IN') return 'India';
    if ($code == 'ID') return 'Indonesia';
    if ($code == 'IR') return 'Iran';
    if ($code == 'IQ') return 'Iraq';
    if ($code == 'IE') return 'Ireland';
    if ($code == 'IM') return 'Isle of Man';
    if ($code == 'IL') return 'Israel';
    if ($code == 'IT') return 'Italy';
    if ($code == 'JM') return 'Jamaica';
    if ($code == 'JP') return 'Japan';
    if ($code == 'JE') return 'Jersey';
    if ($code == 'JO') return 'Jordan';
    if ($code == 'KZ') return 'Kazakhstan';
    if ($code == 'KE') return 'Kenya';
    if ($code == 'KI') return 'Kiribati';
    if ($code == 'KP') return 'Korea';
    if ($code == 'KR') return 'Korea';
    if ($code == 'KW') return 'Kuwait';
    if ($code == 'KG') return 'Kyrgyz Republic';
    if ($code == 'LA') return 'Lao';
    if ($code == 'LV') return 'Latvia';
    if ($code == 'LB') return 'Lebanon';
    if ($code == 'LS') return 'Lesotho';
    if ($code == 'LR') return 'Liberia';
    if ($code == 'LY') return 'Libyan Arab Jamahiriya';
    if ($code == 'LI') return 'Liechtenstein';
    if ($code == 'LT') return 'Lithuania';
    if ($code == 'LU') return 'Luxembourg';
    if ($code == 'MO') return 'Macao';
    if ($code == 'MK') return 'Macedonia';
    if ($code == 'MG') return 'Madagascar';
    if ($code == 'MW') return 'Malawi';
    if ($code == 'MY') return 'Malaysia';
    if ($code == 'MV') return 'Maldives';
    if ($code == 'ML') return 'Mali';
    if ($code == 'MT') return 'Malta';
    if ($code == 'MH') return 'Marshall Islands';
    if ($code == 'MQ') return 'Martinique';
    if ($code == 'MR') return 'Mauritania';
    if ($code == 'MU') return 'Mauritius';
    if ($code == 'YT') return 'Mayotte';
    if ($code == 'MX') return 'Mexico';
    if ($code == 'FM') return 'Micronesia';
    if ($code == 'MD') return 'Moldova';
    if ($code == 'MC') return 'Monaco';
    if ($code == 'MN') return 'Mongolia';
    if ($code == 'ME') return 'Montenegro';
    if ($code == 'MS') return 'Montserrat';
    if ($code == 'MA') return 'Morocco';
    if ($code == 'MZ') return 'Mozambique';
    if ($code == 'MM') return 'Myanmar';
    if ($code == 'NA') return 'Namibia';
    if ($code == 'NR') return 'Nauru';
    if ($code == 'NP') return 'Nepal';
    if ($code == 'AN') return 'Netherlands Antilles';
    if ($code == 'NL') return 'Netherlands the';
    if ($code == 'NC') return 'New Caledonia';
    if ($code == 'NZ') return 'New Zealand';
    if ($code == 'NI') return 'Nicaragua';
    if ($code == 'NE') return 'Niger';
    if ($code == 'NG') return 'Nigeria';
    if ($code == 'NU') return 'Niue';
    if ($code == 'NF') return 'Norfolk Island';
    if ($code == 'MP') return 'Northern Mariana Islands';
    if ($code == 'NO') return 'Norway';
    if ($code == 'OM') return 'Oman';
    if ($code == 'PK') return 'Pakistan';
    if ($code == 'PW') return 'Palau';
    if ($code == 'PS') return 'Palestinian Territory';
    if ($code == 'PA') return 'Panama';
    if ($code == 'PG') return 'Papua New Guinea';
    if ($code == 'PY') return 'Paraguay';
    if ($code == 'PE') return 'Peru';
    if ($code == 'PH') return 'Philippines';
    if ($code == 'PN') return 'Pitcairn Islands';
    if ($code == 'PL') return 'Poland';
    if ($code == 'PT') return 'Portugal, Portuguese Republic';
    if ($code == 'PR') return 'Puerto Rico';
    if ($code == 'QA') return 'Qatar';
    if ($code == 'RE') return 'Reunion';
    if ($code == 'RO') return 'Romania';
    if ($code == 'RU') return 'Russian Federation';
    if ($code == 'RW') return 'Rwanda';
    if ($code == 'BL') return 'Saint Barthelemy';
    if ($code == 'SH') return 'Saint Helena';
    if ($code == 'KN') return 'Saint Kitts and Nevis';
    if ($code == 'LC') return 'Saint Lucia';
    if ($code == 'MF') return 'Saint Martin';
    if ($code == 'PM') return 'Saint Pierre and Miquelon';
    if ($code == 'VC') return 'Saint Vincent and the Grenadines';
    if ($code == 'WS') return 'Samoa';
    if ($code == 'SM') return 'San Marino';
    if ($code == 'ST') return 'Sao Tome and Principe';
    if ($code == 'SA') return 'Saudi Arabia';
    if ($code == 'SN') return 'Senegal';
    if ($code == 'RS') return 'Serbia';
    if ($code == 'SC') return 'Seychelles';
    if ($code == 'SL') return 'Sierra Leone';
    if ($code == 'SG') return 'Singapore';
    if ($code == 'SK') return 'Slovakia (Slovak Republic)';
    if ($code == 'SI') return 'Slovenia';
    if ($code == 'SB') return 'Solomon Islands';
    if ($code == 'SO') return 'Somalia, Somali Republic';
    if ($code == 'ZA') return 'South Africa';
    if ($code == 'GS') return 'South Georgia and the South Sandwich Islands';
    if ($code == 'ES') return 'Spain';
    if ($code == 'LK') return 'Sri Lanka';
    if ($code == 'SD') return 'Sudan';
    if ($code == 'SR') return 'Suriname';
    if ($code == 'SJ') return 'Svalbard & Jan Mayen Islands';
    if ($code == 'SZ') return 'Swaziland';
    if ($code == 'SE') return 'Sweden';
    if ($code == 'CH') return 'Switzerland, Swiss Confederation';
    if ($code == 'SY') return 'Syrian Arab Republic';
    if ($code == 'TW') return 'Taiwan';
    if ($code == 'TJ') return 'Tajikistan';
    if ($code == 'TZ') return 'Tanzania';
    if ($code == 'TH') return 'Thailand';
    if ($code == 'TL') return 'Timor-Leste';
    if ($code == 'TG') return 'Togo';
    if ($code == 'TK') return 'Tokelau';
    if ($code == 'TO') return 'Tonga';
    if ($code == 'TT') return 'Trinidad and Tobago';
    if ($code == 'TN') return 'Tunisia';
    if ($code == 'TR') return 'Turkey';
    if ($code == 'TM') return 'Turkmenistan';
    if ($code == 'TC') return 'Turks and Caicos Islands';
    if ($code == 'TV') return 'Tuvalu';
    if ($code == 'UG') return 'Uganda';
    if ($code == 'UA') return 'Ukraine';
    if ($code == 'AE') return 'United Arab Emirates';
    if ($code == 'GB') return 'United Kingdom';
    if ($code == 'US') return 'United States of America';
    if ($code == 'UM') return 'United States Minor Outlying Islands';
    if ($code == 'VI') return 'United States Virgin Islands';
    if ($code == 'UY') return 'Uruguay, Eastern Republic of';
    if ($code == 'UZ') return 'Uzbekistan';
    if ($code == 'VU') return 'Vanuatu';
    if ($code == 'VE') return 'Venezuela';
    if ($code == 'VN') return 'Vietnam';
    if ($code == 'WF') return 'Wallis and Futuna';
    if ($code == 'EH') return 'Western Sahara';
    if ($code == 'YE') return 'Yemen';
    if ($code == 'XK') return 'Kosovo';
    if ($code == 'ZM') return 'Zambia';
    if ($code == 'ZW') return 'Zimbabwe';
    return 'Country';
}

function socialMediaLogin($Userdata) {

    if(!empty($Userdata))
    {
        // aa($Userdata);
        $insertId = Users::insertGetId($Userdata);
        Session::put('user_id', $insertId);
        /*********adding balance for new user**************/ 
        $CheckUserExist = btg_user_betting_accounts::where('user_id',$value)->get()->toArray();
        if(empty($CheckUserExist))
        {
            $balanceInfo = array('user_id'=>$value,'amount'=>100000,'status'=>1,'updation_date'=>date("Y-m-d H:i:s"));
            $InsertBalance = btg_user_betting_accounts::insert($balanceInfo);
        }
        /*********adding balance for new user**************/
        /********adding points**************/
        $point_obj = point_table::where('user_id',$value)
                    ->where('reason','like','%Login / day.%')
                    ->where('date','like','%'.date('Y-m-d').'%')->first();
        if($point_obj === null){
            UpdatePoints($value,1,'Login / day.');
        }
        /***********************************/
        return true;
        
    }

}
?>
