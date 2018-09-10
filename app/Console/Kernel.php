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
        Commands\startcronjob::class,
        Commands\fetchleaguedata::class,
        Commands\fetcheventdata::class,
        Commands\fetchodds::class,
        Commands\RechargeUserAccount::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('fetch:soccer-feed-for-country')->daily();
        $schedule->command('fetch:soccer-feed-for-league')->daily();
        $schedule->command('fetch:soccer-feed-for-event')->daily();
        $schedule->command('fetch:soccer-feed-for-odds')->daily();
        $schedule->command('fetch:recharge-user-account')->weekly()->mondays()->at('23:59');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
      require base_path('routes/console.php');
    }
}
