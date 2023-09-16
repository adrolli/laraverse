<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('queue:work --once')
            ->everyMinute()
            ->before(function () {
                activity()->log('About to run queue:work');
            })
            ->after(function () {
                activity()->log('Finished running queue:work');
            });

        /* see https://stackoverflow.com/questions/46141652/running-laravel-queuework-on-a-shared-hosting
        $schedule->command('queue:restart')
            ->everyFiveMinutes();
        */
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
