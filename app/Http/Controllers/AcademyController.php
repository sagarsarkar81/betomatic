<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\academies;

class AcademyController extends Controller
{
    public function AcademyPage()
    {
        if(Session::get('user_id') == '')
        {
            return redirect(url('login'));
        }else{
            $GetAcademyContent = academies::where('tab_no','Tab 1')->get()->toArray();
            return view('academy',compact('GetAcademyContent'));
        }
    }
    
    public function Academy2ndTab()
    {
        if(Session::get('user_id') == '')
        {
            return redirect(url('login'));
        }else{
            $GetAcademyContent = academies::where('tab_no','Tab 2')->get()->toArray();
            return view('academy2ndtab',compact('GetAcademyContent'));
        }
    }
    
    public function Academy3rdTab()
    {
        if(Session::get('user_id') == '')
        {
            return redirect(url('login'));
        }else{
            $GetAcademyContent = academies::where('tab_no','Tab 3')->get()->toArray();
            return view('academy3rdtab',compact('GetAcademyContent'));
        }
    }
    
}
?>