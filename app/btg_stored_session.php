<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class btg_stored_session extends Model
{
    protected $fillable = ['email', 'code','from_user'];
    protected $primaryKey = 'id';
}
