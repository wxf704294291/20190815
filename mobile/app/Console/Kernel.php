<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;


class Kernel extends ConsoleKernel
{
    
    protected $commands = [
        Commands\CustomerService::class,
        Commands\ProjectRelease::class,
        Commands\RestoreController::class,
        Commands\RestoreModels::class,
    ];

    
    protected function schedule(Schedule $schedule)
    {
        
    }
}
