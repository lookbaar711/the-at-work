<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ACSettings extends Eloquent
{
    protected $connection = 'mongodb';
	protected $collection = 'ac_settings';
    // protected $dates = [
    //     'classroom_date',
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	's_id',
        's_name',
        's_value',
        'dt_updated'
    ];
}
