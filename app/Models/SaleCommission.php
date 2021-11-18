<?php


namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class SaleCommission extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'sale_commission';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'commission_percent',
    ];
}