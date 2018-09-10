<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class news_feeds extends Model
{
    public $timestamps = false;
    
    public function user()
    {
     return $this->belongsTo('App\User');
    }
}
?>