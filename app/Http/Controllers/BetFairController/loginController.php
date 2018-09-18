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
    	$query = BetfairUserDetail::insert($data);
    	if($query == true)
        {
        	echo "success";
        }else{
        	echo "fail";
        }
    }
}
