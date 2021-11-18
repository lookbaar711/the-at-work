<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class RequestSubjects extends Eloquent
{
  protected $connection = 'mongodb';
  protected $collection = 'requestsubjects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'request_id',
        'request_type',
        'request_date',
        'request_time',
        'request_group_id',
        'request_subject_id',
        'request_topic',
        'request_detail',
        'request_price',
        'request_member_id',
        'request_member_fname',
        'request_member_lname',
        'request_teachers',
        'request_status',
        'request_course_id',
    ];
}
