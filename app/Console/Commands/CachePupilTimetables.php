<?php

namespace App\Console\Commands;

use App\Http\Controllers\ApiController;
use App\Models\School;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CachePupilTimetables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'timetable:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache Pupil Timetables';

    public function __construct(protected ApiController $api)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start = now();

        $pupils = School::allPupils();

        $bar = $this->output->createProgressBar($pupils->count());
        $bar->start();
        foreach ($pupils->sortBy('surname') as $pupil) {
            $emailAddress = $pupil->schoolEmailAddress;

            Cache::remember('getpupiltimetable'.$pupil->schoolEmailAddress, config('cache.time'),
                function () use ($emailAddress) {
                    return $this->api->getPupilTimetable(Str::before($emailAddress, '@'))[ 'timetable' ];
                });
            $this->alert("Completed: ".$pupil->surname.', '.$pupil->forename);
            $bar->advance();
        }
        $timeToComplete = $start->diffInSeconds(now());
        $this->newLine(2);
        $this->comment('Processed in '.$timeToComplete.' seconds');
        return Command::SUCCESS;
    }
}
