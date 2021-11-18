<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\OpenClassRoom::class,
        Commands\CloseClassRoom::class,
        Commands\QueueSendEmail::class,
        // Commands\CheckPrivateClassRoom::class,
        Commands\CheckClassRoom::class,
        Commands\SetOfflineStatus::class,
        Commands\OpenClassRoomRealTime::class, 
        // Commands\CheckPrivateClassRoomRealTime::class,
        // Commands\SendEmailChat::class,
        // Commands\GetBankTransection::class,
        // Commands\SetAutoApproveTopupCoins::class,
        // Commands\GetCoinsCourse::class,
        Commands\SetCancelCourse::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('cron:OpenClassRoom')->everyMinute();
        $schedule->command('cron:CloseClassRoom')->everyMinute();
        $schedule->command('cron:QueueSendEmail')->everyMinute();
        // $schedule->command('cron:CheckPrivateClassRoom')->everyMinute();
        $schedule->command('cron:CheckClassRoom')->everyMinute();
        $schedule->command('cron:SetOfflineStatus')->everyMinute();
        $schedule->command('cron:OpenClassRoomRealTime')->everyMinute();
        // $schedule->command('cron:CheckPrivateClassRoomRealTime')->everyMinute();

        // $schedule->command('cron:SendEmailChat')->everyMinute();
        // $schedule->command('cron:GetBankTransection')->everyMinute();
        // $schedule->command('cron:SetAutoApproveTopupCoins')->everyMinute();
        // $schedule->command('cron:GetCoinsCourse ')->everyMinute();
        
        $schedule->command('cron:SetCancelCourse ')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
