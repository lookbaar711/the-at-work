<?php


namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class BankTransaction extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'bank_transaction';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'report_id', 
        'bank_id', 
        'account_id',
        'member_id',
        'bank_number',
        'way',
        'type',
        'withdraw',
        'deposit',
        'detail',
        'amount',
        'status',
        'caption',
        'timestamp',
        'current_time',
        'ref_id',
    ];
}