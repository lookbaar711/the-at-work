<?php


namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class BankMaster extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'bank_master';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bank_name_th', 
        'bank_name_en', 
        'api_bank_id',
        'bank_status',
    ];
}