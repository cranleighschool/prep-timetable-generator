<?php

namespace Database\Seeders;

use App\Models\PrepDay;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScienceSetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('science_sets')->insert([
            $this->getData(1, 'Biology', 'Thursday'),
            $this->getData(1, 'Chemistry', 'Tuesday'),
            $this->getData(1, 'Physics', 'Friday'),

            $this->getData(2, 'Biology', 'Tuesday'),
            $this->getData(2, 'Chemistry', 'Thursday'),
            $this->getData(2, 'Physics', 'Friday'),

            $this->getData(3, 'Biology', 'Friday'),
            $this->getData(3, 'Chemistry', 'Tuesday'),
            $this->getData(3, 'Physics', 'Thursday'),

            $this->getData(4, 'Biology', 'Friday'),
            $this->getData(4, 'Chemistry', 'Tuesday'),
            $this->getData(4, 'Physics', 'Thursday'),

            $this->getData(5, 'Biology', 'Thursday'),
            $this->getData(5, 'Chemistry', 'Friday'),
            $this->getData(5, 'Physics', 'Tuesday'),

            $this->getData(6, 'Biology', 'Friday'),
            $this->getData(6, 'Chemistry', 'Tuesday'),
            $this->getData(6, 'Physics', 'Thursday'),

            $this->getData(7, 'Biology', 'Thursday'),
            $this->getData(7, 'Chemistry', 'Tuesday'),
            $this->getData(7, 'Physics', 'Friday'),

            $this->getData(8, 'Biology', 'Friday'),
            $this->getData(8, 'Chemistry', 'Tuesday'),
            $this->getData(8, 'Physics', 'Thursday'),
        ]);
        $this->addSubject("Class Civ", 9, [
            1 => "Thursday",
            2 => "Thursday",
            3 => "Wednesday",
            4 => "Wednesday",
            5 => "Wednesday",
            6 => "Tuesday",
        ]);
        $this->addSubject("Geography", 9, [
            1 => "Wednesday",
            2 => "Monday",
            3 => "Tuesday",
            4 => "Wednesday",
            5 => "Monday",
            6 => "Monday",
            7 => "Thursday",
            8 => "Thursday",
        ]);
        $this->addSubject("History", 9, [
            1 => "Monday",
            2 => "Tuesday",
            3 => "Monday",
            4 => "Tuesday",
            5 => "Tuesday",
            6 => "Thursday",
            7 => "Monday",
            8 => "Wednesday",
        ]);
        $this->addSubject("RS", 9, [
            1 => "Tuesday",
            2 => "Wednesday",
            3 => "Wednesday",
            4 => "Monday",
            5 => "Thursday",
            6 => "Tuesday",
            7 => "Wednesday",
            8 => "Monday",
        ]);

        $this->addSubject('Biology', 10, [
            1 => "Tuesday",
            2 => "Tuesday",
            3 => "Tuesday",
            4 => "Thursday",
            5 => "Thursday",
            6 => "Thursday",
            7 => "Thursday",
        ]);
        $this->addSubject('Biology', 10, [
            1 => "Thursday",
            2 => "Thursday",
            3 => "Thursday",
            4 => "Friday",
            5 => "Friday",
            6 => "Friday",
            7 => "Friday",
        ]);

        $this->addSubject('Chemistry', 10, [
            1 => "Wednesday",
            2 => "Wednesday",
            3 => "Wednesday",
            4 => "Tuesday",
            5 => "Tuesday",
            6 => "Tuesday",
            7 => "Tuesday",
        ]);
        $this->addSubject('Chemistry', 10, [
            1 => "Friday",
            2 => "Friday",
            3 => "Friday",
            4 => "Thursday",
            5 => "Thursday",
            6 => "Thursday",
            7 => "Thursday",
        ]);




        $this->addSubject('Physics', 10, [
            1=>'Thursday',
            2=>'Thursday',
            3=>'Thursday',

            4=>'Wednesday',
            5=>'Wednesday',
            6=>'Wednesday',
            7=>'Wednesday',

            8=>'Tuesday',
            9=>'Tuesday'
        ]);
    }

    private function getData(int $set, string $subject, string $day, int $yearGroup = 9)
    {
        $day_id = PrepDay::where("day", $day)->first()->id;
        return [
            "set" => $set,
            "subject" => $subject,
            "day_id" => $day_id,
            "nc_year" => $yearGroup
        ];
    }

    private function addSubject(string $subject, int $yearGroup, array $array)
    {
        foreach ($array as $set => $day) {
            DB::table('science_sets')->insert([
                $this->getData($set, $subject, $day, $yearGroup),
            ]);
        }
    }
}
