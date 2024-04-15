<?php

namespace App\Console\Commands;

use App\Exceptions\ZeroSetsFound;
use App\Http\Controllers\ApiController;
use App\Models\School;
use Carbon\CarbonInterval;
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
     * @throws \Exception
     */
    public function handle(): int
    {
        $start = now();

        $pupils = School::allPupils();

        $bar = $this->output->createProgressBar($pupils->count());
        $bar->start();
        foreach ($pupils->sortBy('surname') as $pupil) {
            $emailAddress = $pupil->schoolEmailAddress;

            Cache::forget('getpupiltimetable' . $pupil->schoolEmailAddress);
            Cache::remember(
                'getpupiltimetable' . $pupil->schoolEmailAddress,
                config('cache.time'),
                function () use ($emailAddress) {
                    try {
                        return $this->api->getPupilTimetable(Str::before($emailAddress, '@'))->getContent();
                    } catch (ZeroSetsFound $e) {
                        $this->newLine();
                        $this->error($e->getMessage());
                    }
                }
            );

            $bar->advance();
        }
        $timeToComplete = $start->diffInSeconds(now());
        $this->newLine(2);
        $this->comment(sprintf('Processed in %s',
            CarbonInterval::seconds(185)
                ->cascade()
                ->forHumans()));

        return self::SUCCESS;
    }
}
