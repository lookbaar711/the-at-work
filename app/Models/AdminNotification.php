<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
//use Tymon\JWTAuth\Contracts\JWTSubject;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContracts;
use Illuminate\Notifications\Notifiable;

class AdminNotification extends Eloquent implements  AuthenticatableContracts
{
    use Notifiable;
    use Authenticatable;
	protected $connection = 'mongodb';
	protected $collection = 'admin_notifications';
    protected $guard = 'web';

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id',
        'member_fullname',
        'noti_to',
        'noti_type',
        'noti_status',
    ];  
    
}