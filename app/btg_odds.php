<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class btg_odds extends Model
{
    public $timestamps = false;

    public function events_table()
    {
    	return $this->belongsTo('App\btg_events','match_id','match_id');
    }
}
?>