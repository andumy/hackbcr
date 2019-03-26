<?php

namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public function team(){
        return $this->belongsTo('App\Team');
    }
}
