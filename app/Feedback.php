<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{

    protected $table = 'feedbacks';

    public function from(){
        return $this->belongsTo('App\User','from_id','id');
    }

    public function to(){
        return $this->belongsTo('App\User','to_id','id');
    }
    
}
