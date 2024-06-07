<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReinstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:reseed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reinstall the app after a fresh install';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->call('down', ['--render' => 'layouts.maintenance']);
        $this->call('migrate:fresh', [
            '--force' => true,
            '--seed' => true,
        ]);
        $this->call('cache:clear');
        $this->call('up');
        $this->call('timetable:cache');

        return self::SUCCESS;
    }
}
