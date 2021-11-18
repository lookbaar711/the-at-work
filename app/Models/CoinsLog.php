<?php


namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CoinsLog extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'coins_log';
    //protected $dates = ['coin_date'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id',
        'member_fname',
        'member_lname',
        'event', //topup_coins, withdraw_coins, pay_coins, get_coins, return_coins, deduct_coins
        'ref_id',
        'ref_name',

        'bank_id', //id ธนาคารระบบ
        'bank_name_en', //ชื่อธนาคารระบบ
        'bank_name_th', //ชื่อธนาคารระบบ
        'bank_account_number', //เลขที่บัญชีธนาคารที่โอนเงินเข้า

        'coin_date',
        'coin_time',

        'member_bank_id', //id ธนาคารของ member
        'member_bank_name_en', //ชื่อธนาคารของ member
        'member_bank_name_th', //ชื่อธนาคารของ member
        'member_account_number', //เลขที่บัญชีธนาคารของ member
        'api_bank_id', //ดึงจาก api_bank_id ใน tb bank_master

        'coin_number',
        'coin_slip',
        'coin_status', //waiting = 0, approve/success = 1, not approve = 2
        'approve_by',
		'coins_description',
    ];
}
