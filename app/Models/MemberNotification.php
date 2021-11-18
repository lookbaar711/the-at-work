<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
//use Tymon\JWTAuth\Contracts\JWTSubject;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContracts;
use Illuminate\Notifications\Notifiable;

class MemberNotification extends Eloquent implements  AuthenticatableContracts
{
    use Notifiable;
    use Authenticatable;
	protected $connection = 'mongodb';
	protected $collection = 'members_notifications';
    protected $guard = 'users';

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id',
        'member_fullname',
        'classroom_name',
        'classroom_date',
        'classroom_time_start',
        'classroom_time_end',
        'teacher_fullname',
        'classroom_url',
        'noti_type',
        'noti_status',
        'course_id',
        'coins_description'
    ];  
    
}