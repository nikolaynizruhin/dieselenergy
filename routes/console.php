<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('cache:prune-stale-tags')->hourly();

Schedule::command('backup:create')->daily();

Schedule::command('backup:clean')->daily();

Schedule::command('rate:update')->weekly();
