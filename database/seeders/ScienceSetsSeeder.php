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
        $this->fourthForm();
        $this->lowerFifth();
        $this->upperFifth();
    }

    private function fourthForm()
    {
        DB::table('science_sets')->insert([

            $this->getData(1, 'Biology', PrepDay::THURSDAY),
            $this->getData(1, 'Chemistry', PrepDay::TUESDAY),
            $this->getData(1, 'Physics', PrepDay::FRIDAY),

            $this->getData(2, 'Biology', PrepDay::FRIDAY),
            $this->getData(2, 'Chemistry', PrepDay::TUESDAY),
            $this->getData(2, 'Physics', PrepDay::THURSDAY),

            $this->getData(3, 'Biology', PrepDay::FRIDAY),
            $this->getData(3, 'Chemistry', PrepDay::TUESDAY),
            $this->getData(3, 'Physics', PrepDay::THURSDAY),

            $this->getData(4, 'Biology', PrepDay::FRIDAY),
            $this->getData(4, 'Chemistry', PrepDay::TUESDAY),
            $this->getData(4, 'Physics', PrepDay::THURSDAY),

            $this->getData(5, 'Biology', PrepDay::THURSDAY),
            $this->getData(5, 'Chemistry', PrepDay::FRIDAY),
            $this->getData(5, 'Physics', PrepDay::TUESDAY),

            $this->getData(6, 'Biology', PrepDay::FRIDAY),
            $this->getData(6, 'Chemistry', PrepDay::TUESDAY),
            $this->getData(6, 'Physics', PrepDay::THURSDAY),

            $this->getData(7, 'Biology', PrepDay::THURSDAY),
            $this->getData(7, 'Chemistry', PrepDay::TUESDAY),
            $this->getData(7, 'Physics', PrepDay::FRIDAY),

            $this->getData(8, 'Biology', PrepDay::THURSDAY),
            $this->getData(8, 'Chemistry', PrepDay::TUESDAY),
            $this->getData(8, 'Physics', PrepDay::FRIDAY),
        ]);
        $this->addSubject('Class Civ', 9, [
            1 => PrepDay::THURSDAY,
            2 => PrepDay::THURSDAY,
            3 => PrepDay::WEDNESDAY,
            4 => PrepDay::WEDNESDAY,
            5 => PrepDay::WEDNESDAY,
            6 => PrepDay::TUESDAY,
        ]);
        $this->addSubject('Geography', 9, [
            1 => PrepDay::MONDAY,
            2 => PrepDay::MONDAY,
            3 => PrepDay::TUESDAY,
            4 => PrepDay::WEDNESDAY,
            5 => PrepDay::MONDAY,
            6 => PrepDay::MONDAY,
            7 => PrepDay::THURSDAY,
            8 => PrepDay::THURSDAY,
        ]);
        $this->addSubject('History', 9, [
            1 => PrepDay::WEDNESDAY,
            2 => PrepDay::TUESDAY,
            3 => PrepDay::MONDAY,
            4 => PrepDay::MONDAY,
            5 => PrepDay::TUESDAY,
            6 => PrepDay::THURSDAY,
            7 => PrepDay::MONDAY,
            8 => PrepDay::WEDNESDAY,
        ]);
        $this->addSubject('RS', 9, [
            1 => PrepDay::TUESDAY,
            2 => PrepDay::WEDNESDAY,
            3 => PrepDay::WEDNESDAY,
            4 => PrepDay::TUESDAY,
            5 => PrepDay::THURSDAY,
            6 => PrepDay::TUESDAY,
            7 => PrepDay::WEDNESDAY,
            8 => PrepDay::MONDAY,
        ]);
    }

    private function getData(int $set, string $subject, string $day, int $yearGroup = 9)
    {
        $day_id = PrepDay::where('day', $day)->first()->id;

        return [
            'set' => $set,
            'subject' => $subject,
            'day_id' => $day_id,
            'nc_year' => $yearGroup,
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

    private function lowerFifth()
    {
        $this->addSubject('Biology', 10, [
            8 => PrepDay::WEDNESDAY,
            9 => PrepDay::WEDNESDAY,
        ]);

        $this->addSubject('Biology', 10, [
            1 => PrepDay::THURSDAY,
            2 => PrepDay::THURSDAY,
            3 => PrepDay::THURSDAY,
            4 => PrepDay::THURSDAY,
            5 => PrepDay::THURSDAY,
            6 => PrepDay::THURSDAY,
            7 => PrepDay::THURSDAY,
        ]);

        $this->addSubject('Chemistry', 10, [
            4 => PrepDay::TUESDAY,
            5 => PrepDay::TUESDAY,
            6 => PrepDay::TUESDAY,
            7 => PrepDay::TUESDAY,
        ]);
        $this->addSubject('Chemistry', 10, [
            1 => PrepDay::WEDNESDAY,
            2 => PrepDay::WEDNESDAY,
            3 => PrepDay::WEDNESDAY,

            4 => PrepDay::THURSDAY,
            5 => PrepDay::THURSDAY,
            6 => PrepDay::THURSDAY,
            7 => PrepDay::THURSDAY,
            8 => PrepDay::THURSDAY,
            9 => PrepDay::THURSDAY,
        ]);

        $this->addSubject('Chemistry', 10, [
            1 => PrepDay::FRIDAY,
            2 => PrepDay::FRIDAY,
            3 => PrepDay::FRIDAY,
        ]);

        $this->addSubject('Physics', 10, [
            1 => PrepDay::TUESDAY,
            2 => PrepDay::TUESDAY,
            3 => PrepDay::TUESDAY,

            8 => PrepDay::TUESDAY,
            9 => PrepDay::TUESDAY,
        ]);

        $this->addSubject('Physics', 10, [
            1 => PrepDay::THURSDAY,
            2 => PrepDay::THURSDAY,
            3 => PrepDay::THURSDAY,

            4 => PrepDay::WEDNESDAY,
            5 => PrepDay::WEDNESDAY,
            6 => PrepDay::WEDNESDAY,
            7 => PrepDay::WEDNESDAY,
        ]);

        $this->addSubject('Physics', 10, [
            4 => PrepDay::FRIDAY,
            5 => PrepDay::FRIDAY,
            6 => PrepDay::FRIDAY,
            7 => PrepDay::FRIDAY,
        ]);
    }

    private function upperFifth()
    {
        // Year 11 Science Sets
        $this->addSubject('Biology', 11, [
            1 => PrepDay::MONDAY,
            2 => PrepDay::MONDAY,
            3 => PrepDay::MONDAY,
            4 => PrepDay::MONDAY,
            5 => PrepDay::MONDAY,
            6 => PrepDay::MONDAY,
            7 => PrepDay::MONDAY,
            8 => PrepDay::MONDAY,
        ]);

        $this->addSubject('Biology', 11, [
            1 => PrepDay::WEDNESDAY,
            2 => PrepDay::WEDNESDAY,
            3 => PrepDay::WEDNESDAY,
            4 => PrepDay::THURSDAY,
            5 => PrepDay::THURSDAY,
            6 => PrepDay::THURSDAY,
        ]);

        $this->addSubject('Chemistry', 11, [
            1 => PrepDay::WEDNESDAY,
            2 => PrepDay::WEDNESDAY,
            3 => PrepDay::WEDNESDAY,
            4 => PrepDay::WEDNESDAY,
            5 => PrepDay::WEDNESDAY,
            6 => PrepDay::WEDNESDAY,
            7 => PrepDay::MONDAY,
            8 => PrepDay::MONDAY,

        ]);

        $this->addSubject('Chemistry', 11, [
            1 => PrepDay::THURSDAY,
            2 => PrepDay::THURSDAY,
            3 => PrepDay::THURSDAY,
            4 => PrepDay::THURSDAY,
            5 => PrepDay::THURSDAY,
            6 => PrepDay::THURSDAY,
        ]);

        $this->addSubject('Physics', 11, [
            1 => PrepDay::MONDAY,
            2 => PrepDay::MONDAY,
            3 => PrepDay::MONDAY,
            4 => PrepDay::MONDAY,
            5 => PrepDay::MONDAY,
            6 => PrepDay::MONDAY,
        ]);

        $this->addSubject('Physics', 11, [
            1 => PrepDay::THURSDAY,
            2 => PrepDay::THURSDAY,
            3 => PrepDay::THURSDAY,
            4 => PrepDay::WEDNESDAY,
            5 => PrepDay::WEDNESDAY,
            6 => PrepDay::WEDNESDAY,
            7 => PrepDay::THURSDAY,
            8 => PrepDay::THURSDAY,
        ]);
    }
}
