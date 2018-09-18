<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Users;
use App\follow_users;
use App\news_feeds;
use Mail;
use GuzzleHttp\Client;

class testing extends Controller
{
    public function index()
    {
        return view('testing');
        //$x = intval(preg_replace('/[^0-9]+/', '', 'ah-0.5'), 10);
        //echo $x;

        // for ($i = 1; $i <= 7; $i++)
        // //{
        //     //$url  = "http://www.goalserve.com/getfeed/130b0528714d46df9a6e7c85e18c6b90/soccernew/d" . $i;
        //     $url = "http://www.goalserve.com/getfeed/130b0528714d46df9a6e7c85e18c6b90/getodds/soccer?cat=soccer";
        //     //$url = "http://www.goalserve.com/getfeed/130b0528714d46df9a6e7c85e18c6b90/getodds/soccer/d";
        //     $curl = curl_init($url);
        //     curl_setopt_array($curl, array(
        //         CURLOPT_ENCODING => 'gzip', // specify that we accept all supported encoding types
        //         CURLOPT_RETURNTRANSFER => true
        //     ));
        //     $xml = curl_exec($curl);
        //     curl_close($curl);
        //     if ($xml === false) {
        //         die('Can\'t get file');
        //     }
        //     $obj = simplexml_load_string($xml);
        //     //echo "<pre>";
        //     //print_r($obj);die;
        //     foreach ($obj->matches->odds as $row)
        //     {
        //         //echo "<pre>";
        //         //print_r($row);
        //         echo $row['odd'];echo "<br>";
        //         /*$league = array();
        //         $league['c_id'] = (string) $row['id'];
        //         if (getSelectedValue('id', LEAGUE_DETAILS_TABLE, "c_id='" . $league['c_id'] . "'") == 0)
        //         {
        //              $league['sport_type']  = (string) $obj['sport'];
        //              $league['category_name'] = (string) str_replace($row['file_group'] . ':', '', $row['name']);
        //              $league['gid']           = (string) $row['gid'];
        //              $league['c_id']          = (string) $row['id'];
        //              $league['file_group']    = (string) $row['file_group'];
        //              $this->Common_model->commonInsertArray(LEAGUE_DETAILS_TABLE, $league);
        //         }
        //             $data = array();
        //             $data['c_id'] = (string) $row['gid'];*/
        //     }
        //}
        //echo date("H:i:s");
        //$obj = null;

        //echo custom_name();
        /*$encoded_url = urlencode( $this->getUrl() );
        if ( !empty($encoded_url) ){ ?>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $encoded_url; ?>" target="_blank">
         Share this page on Facebook
        </a>
        <?php } */
        /*$query = follow_users::with('users')->where('to_user_id',5)->get()->toArray();
        $msg = 'You are followed';
        $data['msg'] = $msg;
        $email = 'sumit.wgt@gmail.com';
        follow_mail($data,$email);
        echo "success";*/
        //echo "<pre>";
        //print_r($query);

    }
    function getUrl() {
        $url  = isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ? 'https' : 'http';
        $url .= '://' . $_SERVER['SERVER_NAME'];
        $url .= in_array( $_SERVER['SERVER_PORT'], array('80', '443') ) ? '' : ':' . $_SERVER['SERVER_PORT'];
        $url .= $_SERVER['REQUEST_URI'];
        return $url;
    }

    public function postUpload()
    {
        if(Input::file())
        {
            $image = Input::file('input_img');
            $filename  = time() . '.' . $image->getClientOriginalExtension();
            echo
            $path = public_path('assets/front_end/images' . $filename);
            Image::make($image->getRealPath())->resize(200, 200)->save($path);
            $user->image = $filename;
            $user->save();
        }
    }

    public function testing()
    {
        $GetUserName = news_feeds::select('name')->leftJoin('users', 'users.id', '=', 'news_feeds.user_id')->get()->toArray();
        echo "<pre>";
        print_r($GetUserName);
    }

    public function TestingGuzzle()
    {
        // $APIkey='c6d035e55cec51b1a92cebf6f6c31c553c46639ac654ce0bca6690def88eea03';
        // $url="https://apifootball.com/api/?action=get_standings&league_id=376&APIkey=".$APIkey;
        // $url = "https://identitysso.betfair.com/api/login ";
        // $client = new Client();
        // $response = $client->post($url, array(
        // 'headers' => array(
        //     'Accept' => 'application/json',
        //     'X-Application' => 'IDolhrqI0275hGow',
        //     'Content-Type' => 'application/x-www-form-urlencoded'
        //     ),
        // 'body' => array(
        //     'email' => 'test@gmail.com',
        //     'name' => 'Test user',
        //     'password' => 'testpassword'
        //     )
        // ));
        // $res = json_decode($response,true);
        // echo "<pre>";
        // print_r($res);die;


        // $url = "https://identitysso.betfair.com/api/login ";
        // $headers['Accept'] = "application/json";
        // $headers['X-Application'] = "IDolhrqI0275hGow";
        $body['username'] = "Solibet";
        $body['password'] = "Solibet1";
        //aa($body);
        //$response = $client->createRequest("POST", $url, ['body'=>$body]);
        //$response = $client->post($url,$headers,$body);
        //aa($response);
        //$request = $client->post($url,  ['body'=>$body]);
        // $response = $client->send($response);
        // echo "<pre>";
        // print_r($response);die;
       
        // aa($request = $this->client->post($url,array(
        //         'content-type' => 'application/json'
        // ),array()));
        // $request->setBody($body); #set body!
        // $response = $request->send();
        // aa($response);
        //return $response;
        $url = "https://identitysso.betfair.com/api/login ";
        aa(sendDataByCurl($url, $body));
    }
}

?>
