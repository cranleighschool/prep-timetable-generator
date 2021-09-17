<?php

namespace Database\Seeders;

use App\Models\PrepDay;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PrepDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = [
            'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'
        ];
        foreach ($days as $day) {
            PrepDay::firstOrCreate([
                'day' => $day
            ]);
        }
    }
}
