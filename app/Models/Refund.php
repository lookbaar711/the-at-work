<?php


namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Refund extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'refund';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id',
        'member_fullname',
        'course_id', 
        'course_name', 

        'teacher_id', 
        'teacher_fullname', 
        'course_price', 

        'refund_reason',
        'refund_status',
        'refund_approve',
        'refund_description',
    ];
}
