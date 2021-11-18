<?php


namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Withdraw extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'withdraw_coins';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id',
        'member_fname',
        'member_lname',

        'withdraw_bank_id', //id ธนาคารที่โอนเงินออก
        'withdraw_bank_name_en', //ชื่อธนาคารที่โอนเงินออก
        'withdraw_bank_name_th', //ชื่อธนาคารที่โอนเงินออก
        'withdraw_account_number', //เลขที่บัญชีธนาคารที่โอนเงินออก
        
        'withdraw_coin_number',
        'withdraw_date',
        'withdraw_time',

        'member_bank_id', //id ธนาคารที่โอนเงินเข้า
        'member_bank_name_en', //ชื่อธนาคารที่โอนเงินเข้า
        'member_bank_name_th', //ชื่อธนาคารที่โอนเงินเข้า
        'member_account_number', //เลขที่บัญชีธนาคารที่โอนเงินเข้า
        'api_bank_id', //ดึงจาก api_bank_id ใน tb bank_master

        'withdraw_status',
        'withdraw_approve',
        'withdraw_type',
		'coins_description',
    ];
}
