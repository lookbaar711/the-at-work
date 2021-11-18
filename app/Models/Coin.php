<?php


namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Coin extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'coins';
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

        'coin_bank_id', //id ธนาคารที่โอนเงินเข้า
        'coin_bank_name_en', //ชื่อธนาคารที่โอนเงินเข้า
        'coin_bank_name_th', //ชื่อธนาคารที่โอนเงินเข้า
        'coin_account_number', //เลขที่บัญชีธนาคารที่โอนเงินเข้า

        'coin_date',
        'coin_time',

        'member_bank_id', //id ธนาคารที่โอนเงินออก
        'member_bank_name_en', //ชื่อธนาคารที่โอนเงินออก
        'member_bank_name_th', //ชื่อธนาคารที่โอนเงินออก
        'member_account_number', //เลขที่บัญชีธนาคารที่โอนเงินออก
        'api_bank_id', //ดึงจาก api_bank_id ใน tb bank_master
        
        'coin_number',
        'coin_slip',
        'coin_status',
        'coin_approve',
        'coin_type',
		'coins_description',
    ];
}
