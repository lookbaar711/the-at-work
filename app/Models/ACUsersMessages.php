<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ACUsersMessages extends Eloquent
{
    protected $connection = 'mongodb';
	protected $collection = 'ac_users_messages';
    // protected $dates = [
    //     'classroom_date',
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'users_id',
        'buddy_id',
        'messages_count',
        'is_send',
        'updated_at'
    ];
}
