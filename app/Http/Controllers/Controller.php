<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function __construct(){
        $this->middleware(function($request,$next){
              // Session::put('language', 'fr');
             $default_language = Session::has('language') ? Session::get('language') : 'sek';
            //\Config::set('sitesettings.fallback_locale',$default_language); 
            \App::setLocale($default_language);
              return $next($request);
        });
    }
}
?>