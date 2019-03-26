<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function department(){
        return $this->belongsTo('App\Department');
    }

    public function teams(){
        return $this->hasMany('App\Teams');
    }

    public function getAvatar(int $size = 64) {
        return "https://ui-avatars.com/api/?name={$this->first_name}+{$this->last_name}&bold=true&background=11cdef&color=fff&font-size=0.33&size=$size";
    }

    public function tokens(){
        return $this->hasMany('App\Token');
    }

    public function loginToken(){
        $token = $this->tokens()->where('used',false)->orderBy('created_at','desc')->first();

        if(!$token){
            return Redirect::back()->withErrors(['msg', 'Incorrect code']);
        }

        return $token;
    }

    public function generateToken(){

        $token = new Token();
        $token->user_id = $this->id;
        $token->type = 'login';
        $token->transaction_id = null;
        $token->token = mt_rand(10000,99999);
        $token->used = false;
        $token->save();
    }
}
