<?php


namespace App\Models;

use Illuminate\Auth\Authenticatable;
//use Tymon\JWTAuth\Contracts\JWTSubject;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContracts;
use Illuminate\Notifications\Notifiable;

class Admin extends Eloquent implements  AuthenticatableContracts
{
    use Notifiable;
    use Authenticatable;
	protected $connection = 'mongodb';
	protected $collection = 'admin';
    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'status',
    ];  

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

}