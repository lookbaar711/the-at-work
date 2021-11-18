<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Member;
use App\Models\Test;
use App\Models\BankTransaction;
use App\Models\Coin;
use App\Models\CoinsLog;
use App\Models\MemberNotification;
use App\Events\SendNotiFrontend;
use Sentinel;
use Mail;

use App\Http\Controllers\backend\CoinsController;

class SetAutoApproveTopupCoins extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:SetAutoApproveTopupCoins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set auto approve topup coins every 1 minute using cron job';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->CoinsController = new CoinsController();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        return $this->CoinsController->setAutoApproveTopupCoins();
    }

}
