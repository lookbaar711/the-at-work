<?php
namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Course_private extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'course_private';
    // protected $dates = [
    //     'course_date'
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id',
        'member_fname',
        'member_lname',
        'member_email',
        'course_name',
        'course_detail',
        'course_group',
        'course_subject',
        'course_date',
        'course_time_start',
        'course_time_end',
        'course_type',
        'course_price',
        'course_img',
        'course_file',
        'course_student_limit',
        'course_status',
    ];
}