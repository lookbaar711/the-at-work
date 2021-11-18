<?php


namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class RatingQuestions extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'rating_questions';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_th',
        'question_en',
        'question_type',
        'question_order',
        'question_status',
    ];
}