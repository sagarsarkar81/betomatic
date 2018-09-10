<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Users;
use App\leaderboards;
use Session;
class LeaderBoardController extends Controller
{
    public function Leaderboard()
    {
        if(Session::get('user_id') == '')
        {
            return redirect(url('login'));
        }
        else{
            $userId = Session::get('user_id');
            return view('LeaderboardMainPage');
        }
    }
    
    public function GetAllLeaderBoardData(Request $request)
    {
        $userId = Session::get('user_id');
        //$CurrentDate = date("Y-m-d H:i:s");
        $Days = '365';
        $date = \Carbon\Carbon::today()->subDays($Days);
        $GetLeaderBoardsData = leaderboards::where('creation_date',">=",date($date))->orderBy('hit_rate', 'DESC')->get()->toArray();
        //echo "<pre>";
        //print_r($GetLeaderBoardsData);
        return view('leaderboard',compact('GetLeaderBoardsData'));
    }
    
    public function GetLeaderBoardDataDayWise(Request $request)
    {
        $Days = $request->input('day');
        $date = \Carbon\Carbon::today()->subDays($Days);
        $GetLeaderBoardsData = leaderboards::where('creation_date','>=',date($date))->orderBy('hit_rate', 'DESC')->get()->toArray();
        //echo "<pre>";
        //print_r($GetLeaderBoardsData);die;
        return view('leaderboard',compact('GetLeaderBoardsData'));
    }
}
?>