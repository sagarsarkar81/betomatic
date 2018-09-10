<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Users;
class follow_users extends Model
{
    protected $table = 'follow_users';
    public $timestamps = false;
    
    public function users()
    {
        return $this->belongsTo('App\Users','to_user_id','id');
    }
}
?>