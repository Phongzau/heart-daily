<?php

use App\Services\ChatService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('process:pending-messages', function (Schedule $schedule) {
    $schedule->call(function () {
        app(ChatService::class)->processPendingMessages();
    })->everyMinute();
});