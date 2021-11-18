<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ACMessages extends Eloquent
{
    protected $connection = 'mongodb';
	protected $collection = 'ac_messages';
    // protected $dates = [
    //     'classroom_date',
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'm_from',
        'm_to',
        'message',
        'is_read',
        'm_from_delete',
        'm_to_delete',
        'dt_updated'
    ];
}
