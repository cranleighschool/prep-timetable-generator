<?php

namespace App\Console\Commands;

use Carbon\CarbonInterval;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
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

    /**
     * Execute the console command.
     *
     * @throws Exception
     */
    public function handle(): int
    {
        $start = now();

        $houses = Arr::map((array) config('timetable.houses'), fn (string $house) => Str::slug($house));
        $bar = $this->output->createProgressBar(count($houses));
        $bar->start();

        foreach ($houses as $house) {
            Http::timeout(120)->get(url('house/'.$house))->throw()->json();
            $bar->advance();
        }

        $timeToComplete = $start->diffInSeconds(now());
        $this->newLine(2);
        $this->comment(sprintf('Processed in %s',
            CarbonInterval::seconds($timeToComplete)
                ->cascade()
                ->forHumans()));

        return self::SUCCESS;
    }
}
