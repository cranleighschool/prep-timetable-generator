<?php

namespace App\Console\Commands;

use App\Models\SubjectsSet;
use Database\Seeders\SetsSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetSubjectSetDays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'timetable:reset';

    protected string $table;

    public function __construct()
    {
        parent::__construct();

        $this->table = app(SubjectsSet::class)->getTable();

        $this->setDescription('Purges the '.$this->table.' table and reseeds it');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table($this->table)->truncate();
        $this->info('Truncated Table');
        $this->call('db:seed', ['class' => SetsSeeder::class]);
        $this->info('Done');

        return 0;
    }
}
