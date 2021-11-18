<?php
namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Event extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'events';
    // protected $dates = [
    //     'course_date'
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_name',
        'event_detail',
        'event_location',
        'event_start_date',
        'event_end_date',
        'event_status',
    ];
}