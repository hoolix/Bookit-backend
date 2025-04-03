<?php 

namespace App\Console;

use App\Console\Commands\CleanExpiredTokens;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        CleanExpiredTokens::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Run the cleanup command every day at midnight
        $schedule->command('tokens:clean-expired')->dailyAt('00:00');
    }

    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
