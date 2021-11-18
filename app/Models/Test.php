<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
//use Tymon\JWTAuth\Contracts\JWTSubject;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContracts;
use Illuminate\Notifications\Notifiable;

class Test extends Eloquent implements  AuthenticatableContracts
{
    use Notifiable;
    use Authenticatable;
	protected $connection = 'mongodb';
	protected $collection = 'test';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time'
    ];  
    
    

}