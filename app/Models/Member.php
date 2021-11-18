<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
//use Tymon\JWTAuth\Contracts\JWTSubject;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContracts;
use Illuminate\Notifications\Notifiable;

class Member extends Eloquent implements  AuthenticatableContracts
{
    use Notifiable;
    use Authenticatable;
	protected $connection = 'mongodb';
	protected $collection = 'members';
    protected $guard = 'users';
    protected $dates = [
        'member_Bday',
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id',
        'member_email',
        'member_password',
        'member_real_password',
        'member_sername',
        'member_fname',
        'member_lname',
        'member_fullname',
        'member_nickname',
        'member_Bday',
        'member_tell',
        'member_idLine',
        'member_address',
        'member_idCard',
        'member_rate_start',
        'member_rate_end',
        'member_education',
        'member_exp',
        'member_cong',
        'member_aptitude',
        'member_file',
        'member_coins',
        'member_img',
        'member_strlenPass',
        'member_status',
        'member_type',
        'member_teacher',
        'mid',
        'online_status',
        'last_action_at',
        'event_id',
        'promotion_code',
        'member_role',
        'member_lang',
    ];  

    protected $hidden = [
        'member_password', 'remember_token',
    ];
    
    public function getAuthPassword ()
    {
        return $this->member_password;
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

}