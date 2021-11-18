<?php


namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Subject extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'subject';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject_id', 
        'subject_name_th', 
        'subject_name_en',
        'is_master',
        'aptitude_id',
        'member_id',
    ];
}