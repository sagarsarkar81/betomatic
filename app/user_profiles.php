<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_profiles extends Model
{
    public $timestamps = false;
    public function FavouriteSports()
    {
        return $this->belongsTo('App\favourite_sports','favourite_sports','id');
    }
}
?>