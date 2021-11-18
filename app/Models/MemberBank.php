<?php


namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class MemberBank extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'members_bank';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id', 
        'bank_id', 
        'bank_name_th', 
        'bank_name_en', 
        'bank_account_number',
        'account_status',
    ];
}