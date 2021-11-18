<?php


namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class BBBSettings extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'bbb_settings';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'server_amount', 
        'camera_per_server', 
        'bbb_url_1',
        'bbb_url_2',
        'bbb_url_3',
        'bbb_url_4',
        'bbb_url_5',
        'bbb_shared_secret_1',
        'bbb_shared_secret_2',
        'bbb_shared_secret_3',
        'bbb_shared_secret_4',
        'bbb_shared_secret_5',
    ];
}