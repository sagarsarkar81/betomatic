<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class btg_events extends Model
{
    public $timestamps = false;
    
    public function league()
    {
     return $this->belongsTo('App\btg_leagues','league_id','league_id');
    }

    public function odds()
    {
    	return $this->hasMany('App\btg_odds','match_id','match_id');
    }

    /*public function events()
    {
    	return $this->belongsTo('App\btg_odds','btg_odds','match_id');
    }*/
    
}
?>
