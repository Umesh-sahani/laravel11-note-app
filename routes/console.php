<?php


use Illuminate\Support\Facades\Schedule;


Schedule::command('updatedb:cron')->everyMinute();
