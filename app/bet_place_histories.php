<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bet_place_histories extends Model
{
    public $timestamps = false;
    
    public function event()
    {
     return $this->belongsTo('App\btg_events','match_id','match_id');
    }
}
?>