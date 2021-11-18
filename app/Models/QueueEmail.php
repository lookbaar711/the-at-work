<?php
namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class QueueEmail extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'queue_email';
    // protected $dates = [
    //     'course_date'
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email_type', //
        'data',
        'subject',
        'from_name',
        'from_email',
        'to_name',
        'to_email',
        'queue_status',
    ];
}