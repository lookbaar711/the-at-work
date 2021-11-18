<?php


namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Bank extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'bank';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bank_id',
        'bank_name_th',
        'bank_name_en', 
        'bank_code',
        'api_bank_id', 
        'account_name',
        'bank_account_number',
        'bank_img',
        'bank_status',
    ];
}