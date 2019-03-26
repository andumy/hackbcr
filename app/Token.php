<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    const EXPIRATION_TIME = 15; // minutes

	protected $fillable = [
        'token',
        'user_id',
        'type',
        'transaction_id',
        'used'
    ];

	public function user(){
        return $this->belongsTo('App\User');
    }

    public function transaction(){
        return $this->belongsTo('App\Transaction');
    }

    /** True if the token is not used nor expired
     *
     * @return bool
     */
    public function isValid()
    {
        return ! $this->isUsed() && ! $this->isExpired();
    }

    /**
     * Is the current token used
     *
     * @return bool
     */
    public function isUsed()
    {
        return $this->used;
    }

    /**
     * Is the current token expired
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->created_at->diffInMinutes(Carbon::now()) > static::EXPIRATION_TIME;
    }
}
