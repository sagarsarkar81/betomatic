<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class btg_featured_matches extends Model
{
    public $timestamps = false;

    public function FeaturedMatch()
    {
    	return $this->belongsTo('App\btg_events','event_id','id');
    }

    public function FeaturedMatchOdds()
    {
    	return $this->hasMany('App\btg_odds','match_id','match_id');
    }
}
