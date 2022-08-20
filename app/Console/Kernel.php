<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use React\EventLoop\LoopInterface;
use Spatie\ShortSchedule\ShortSchedule;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call('App\Http\Controllers\OrderBookController@fillOrderBook')->everyMinute();
    }

    /**
     * @param ShortSchedule $shortSchedule
     * @return void
     */
    public function shortSchedule(ShortSchedule $shortSchedule)
    {
        // this artisan command will run every 10 second
        $shortSchedule->command('schedule:run')->everySeconds(10)->withoutOverlapping();
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
