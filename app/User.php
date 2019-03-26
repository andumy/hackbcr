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
        'first_name', 'last_name', 'email', 'password', 'department_id','phone'
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
        return $this->belongsToMany('App\Team');
    }

    public function sentFeedbacks(){
        return $this->hasMany('App\Feedback','from_id','id');
    }

    public function recievedFeedbacks(){
        return $this->hasMany('App\Feedback','to_id','id');
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

        $telefon = $this->phone;
        $send_token = $token->token;
        $ch = curl_init();
        $user = env('SMSHW_USER',null);
        $password = env('SMSHW_PASSWORD',null);
        $number = "$telefon";
        $label = 'CodeFest';
        $text = "Your code is $send_token";
        $data = array(
         'user' => $user,
         'number' => $number,
         'text' => $text,
         'label' => $label,
         'sum' => sha1($user . $number . $text . $label . sha1($password))
        );
        curl_setopt($ch, CURLOPT_URL, 'https://api.smshighway.com/sms/send');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $request_output = curl_exec($ch);
        $request_info = curl_getinfo($ch);

    }
}
