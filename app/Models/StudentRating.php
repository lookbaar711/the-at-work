<?php


namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class StudentRating extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'student_rating';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'teacher_id',
        'member_id',
        'rating',
        'average_rating',
        'recommend',
        'rating_status',
    ];
}