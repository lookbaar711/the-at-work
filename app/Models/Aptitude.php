<?php


namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Aptitude extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'aptitude';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'aptitude_name_th',
        'aptitude_name_en',
        'aptitude_subject',
    ];  
}