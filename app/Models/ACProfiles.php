<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ACProfiles extends Eloquent
{
    protected $connection = 'mongodb';
	protected $collection = 'ac_profiles';
    // protected $dates = [
    //     'classroom_date',
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id',
        'fullname',
        'avatar',
        'status',
        'dt_updated'
    ];
}
