<?php

namespace PageLab\ServerMail\Console;

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
        \PageLab\ServerMail\Console\Commands\Inspire::class,
        \PageLab\ServerMail\Console\Commands\CreateLinuxUser::class,
        \PageLab\ServerMail\Console\Commands\DeleteLinuxUser::class,
        \PageLab\ServerMail\Console\Commands\CreateLinuxDomain::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
    }
}
