<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
         $schedule->call(function(){
            $response = Http::get('https://jsonplaceholder.typicode.com/comments');
            $response = $response->json();
            foreach($response as $item){
                $fileName = strtok($item['name'],' ');
                Storage::disk('public')->put($fileName,'Hellow world');
            }
         })->everyFiveSeconds();
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
