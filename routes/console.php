<?php

// use App\Jobs\SendRenewalRemindersJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule::job(new SendRenewalRemindersJob())->daily();
Schedule::command('subscriptions:check')
        //  ->dailyAt('00:01') // يوميًا الساعة 00:01
        ->everyMinute()
         ->withoutOverlapping()
         ->runInBackground();
