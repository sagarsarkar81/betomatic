<?php

namespace App\Http\Controllers\BetFairController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\BetfairModels\BetfairUserDetail;

class loginController extends Controller
{
    public function BetfairLogin(Request $request) {
    	$userId = Session::get('user_id');
    	$username = $request->input('betfair_username');
    	$password = $request->input('betfair_password');
    	$data = array('btg_user_id' => $userId,
    				  'betfair_username' => $username,
    				  'betfair_password' => $password,
    				  'creation_date' => date("Y-m-d H:i:s"),
					  'updation_date' => date("Y-m-d H:i:s"),
    				 );
        $body['username'] = $username;
        $body['password'] = $password;
        $url = "https://identitysso.betfair.com/api/login";
        $response = sendDataByCurl($url, $body);
        if($response->status === "SUCCESS") {
            Session::put('user_token', $response->token);
            $query = BetfairUserDetail::insert($data);
            $msg = "Logged in successfully";
            $status = "success";
            $type = "success";
        } elseif($response->status === "LOGIN_RESTRICTED") {
            $msg = "Login is restricted";
            $status = "restricted";
            $type = "restricted";
        } elseif($response->status === "FAIL") {
            $msg = "Login failed";
            $status = "fail";
            $type = "fail";
        }
        $request->session()->flash($type, $msg);
        echo $status;
    	
    }

    public function BetfairLoginNormal(Request $request) {
        $username = $request->input('betfair_username');
        $password = $request->input('betfair_password');
        $body['username'] = $username;
        $body['password'] = $password;
        $url = "https://identitysso.betfair.com/api/login ";
        $response = sendDataByCurl($url, $body);
        if($response->status === "SUCCESS") {
            Session::put('user_token', $response->token);
            $msg = "Logged in successfully";
            $status = "success";
            $type = "success";
        } elseif($response->status === "LOGIN_RESTRICTED") {
            $msg = "Login is restricted";
            $status = "restricted";
            $type = "restricted";
        } elseif($response->status === "FAIL") {
            $msg = "Login failed";
            $status = "fail";
            $type = "fail";
        }
        $request->session()->flash($type, $msg);
        echo $status;
    }
}
