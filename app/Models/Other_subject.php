<?php
namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Other_subject extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'other_subjects';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id',
        'subject_name',
        'aptitude_name',
    ];
}