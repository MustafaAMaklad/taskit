<?php

use App\Console\Commands\MarkOverdueTask;
use Illuminate\Support\Facades\Schedule;

Schedule::command(MarkOverdueTask::class)->everySecond();
