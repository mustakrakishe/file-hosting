<?php

use App\Console\Commands\File\Prune;
use Illuminate\Support\Facades\Schedule;

Schedule::command(Prune::class)->everyMinute();