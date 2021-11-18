<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Sentinel;

class SetOfflineStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:SetOfflineStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set offline status every 1 minute using cron job';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        $today = date('Y-m-d');
        $time = date('H:i:s');
        $before_time = date('Y-m-d H:i:s',strtotime('-1 hours'));

        $queues = Member::where('last_action_at', '<' , $before_time)
                    ->update(['online_status' => '0']);
    }
}
