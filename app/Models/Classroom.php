<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Classroom extends Eloquent
{
    protected $connection = 'mongodb';
	protected $collection = 'classroom';
    // protected $dates = [
    //     'classroom_date',
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'course_id',
        'classroom_name',
        'classroom_schedule',
        'classroom_date',
        'classroom_time_start',
        'classroom_time_end',
        'classroom_teacher',
        'classroom_student',
        'classroom_status',
        'classroom_category',
        'classroom_server'
    ];
}
