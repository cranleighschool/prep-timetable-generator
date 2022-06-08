<?php

namespace Database\Seeders;

use App\Logic\GenerateTimetable;
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

    /**
     * @return void
     */
    private function fourthForm(): void
    {
        DB::table('science_sets')->insert([

            $this->getData(1, 'Biology', GenerateTimetable::THURSDAY),
            $this->getData(1, 'Chemistry', GenerateTimetable::TUESDAY),
            $this->getData(1, 'Physics', GenerateTimetable::FRIDAY),

            $this->getData(2, 'Biology', GenerateTimetable::FRIDAY),
            $this->getData(2, 'Chemistry', GenerateTimetable::TUESDAY),
            $this->getData(2, 'Physics', GenerateTimetable::THURSDAY),

            $this->getData(3, 'Biology', GenerateTimetable::FRIDAY),
            $this->getData(3, 'Chemistry', GenerateTimetable::TUESDAY),
            $this->getData(3, 'Physics', GenerateTimetable::THURSDAY),

            $this->getData(4, 'Biology', GenerateTimetable::FRIDAY),
            $this->getData(4, 'Chemistry', GenerateTimetable::TUESDAY),
            $this->getData(4, 'Physics', GenerateTimetable::THURSDAY),

            $this->getData(5, 'Biology', GenerateTimetable::THURSDAY),
            $this->getData(5, 'Chemistry', GenerateTimetable::FRIDAY),
            $this->getData(5, 'Physics', GenerateTimetable::TUESDAY),

            $this->getData(6, 'Biology', GenerateTimetable::FRIDAY),
            $this->getData(6, 'Chemistry', GenerateTimetable::TUESDAY),
            $this->getData(6, 'Physics', GenerateTimetable::THURSDAY),

            $this->getData(7, 'Biology', GenerateTimetable::THURSDAY),
            $this->getData(7, 'Chemistry', GenerateTimetable::TUESDAY),
            $this->getData(7, 'Physics', GenerateTimetable::FRIDAY),

            $this->getData(8, 'Biology', GenerateTimetable::THURSDAY),
            $this->getData(8, 'Chemistry', GenerateTimetable::TUESDAY),
            $this->getData(8, 'Physics', GenerateTimetable::FRIDAY),
        ]);
        $this->addSubject('Class Civ', 9, [
            1 => GenerateTimetable::THURSDAY,
            2 => GenerateTimetable::THURSDAY,
            3 => GenerateTimetable::WEDNESDAY,
            4 => GenerateTimetable::WEDNESDAY,
            5 => GenerateTimetable::WEDNESDAY,
            6 => GenerateTimetable::TUESDAY,
        ]);
        $this->addSubject('Geography', 9, [
            1 => GenerateTimetable::MONDAY,
            2 => GenerateTimetable::MONDAY,
            3 => GenerateTimetable::TUESDAY,
            4 => GenerateTimetable::WEDNESDAY,
            5 => GenerateTimetable::MONDAY,
            6 => GenerateTimetable::MONDAY,
            7 => GenerateTimetable::THURSDAY,
            8 => GenerateTimetable::THURSDAY,
        ]);
        $this->addSubject('History', 9, [
            1 => GenerateTimetable::WEDNESDAY,
            2 => GenerateTimetable::TUESDAY,
            3 => GenerateTimetable::MONDAY,
            4 => GenerateTimetable::MONDAY,
            5 => GenerateTimetable::TUESDAY,
            6 => GenerateTimetable::THURSDAY,
            7 => GenerateTimetable::MONDAY,
            8 => GenerateTimetable::WEDNESDAY,
        ]);
        $this->addSubject('RS', 9, [
            1 => GenerateTimetable::TUESDAY,
            2 => GenerateTimetable::WEDNESDAY,
            3 => GenerateTimetable::WEDNESDAY,
            4 => GenerateTimetable::TUESDAY,
            5 => GenerateTimetable::THURSDAY,
            6 => GenerateTimetable::TUESDAY,
            7 => GenerateTimetable::WEDNESDAY,
            8 => GenerateTimetable::MONDAY,
        ]);
    }

    /**
     * @param  int  $set
     * @param  string  $subject
     * @param  string  $day
     * @param  int  $yearGroup
     *
     * @return array
     */
    private function getData(int $set, string $subject, string $day, int $yearGroup = 9): array
    {
        $day_id = PrepDay::where('day', $day)->first()->id;

        return [
            'set' => $set,
            'subject' => $subject,
            'day_id' => $day_id,
            'nc_year' => $yearGroup,
        ];
    }

    /**
     * @param  string  $subject
     * @param  int  $yearGroup
     * @param  array  $array
     *
     * @return void
     */
    private function addSubject(string $subject, int $yearGroup, array $array): void
    {
        foreach ($array as $set => $day) {
            DB::table('science_sets')->insert([
                $this->getData($set, $subject, $day, $yearGroup),
            ]);
        }
    }

    /**
     * @return void
     */
    private function lowerFifth(): void
    {
        $this->addSubject('Biology', 10, [
            8 => GenerateTimetable::WEDNESDAY,
            9 => GenerateTimetable::WEDNESDAY,
        ]);

        $this->addSubject('Biology', 10, [
            1 => GenerateTimetable::THURSDAY,
            2 => GenerateTimetable::THURSDAY,
            3 => GenerateTimetable::THURSDAY,
            4 => GenerateTimetable::THURSDAY,
            5 => GenerateTimetable::THURSDAY,
            6 => GenerateTimetable::THURSDAY,
            7 => GenerateTimetable::THURSDAY,
        ]);

        $this->addSubject('Chemistry', 10, [
            4 => GenerateTimetable::TUESDAY,
            5 => GenerateTimetable::TUESDAY,
            6 => GenerateTimetable::TUESDAY,
            7 => GenerateTimetable::TUESDAY,
        ]);
        $this->addSubject('Chemistry', 10, [
            1 => GenerateTimetable::WEDNESDAY,
            2 => GenerateTimetable::WEDNESDAY,
            3 => GenerateTimetable::WEDNESDAY,

            4 => GenerateTimetable::THURSDAY,
            5 => GenerateTimetable::THURSDAY,
            6 => GenerateTimetable::THURSDAY,
            7 => GenerateTimetable::THURSDAY,
            8 => GenerateTimetable::THURSDAY,
            9 => GenerateTimetable::THURSDAY,
        ]);

        $this->addSubject('Chemistry', 10, [
            1 => GenerateTimetable::FRIDAY,
            2 => GenerateTimetable::FRIDAY,
            3 => GenerateTimetable::FRIDAY,
        ]);

        $this->addSubject('Physics', 10, [
            1 => GenerateTimetable::TUESDAY,
            2 => GenerateTimetable::TUESDAY,
            3 => GenerateTimetable::TUESDAY,

            8 => GenerateTimetable::TUESDAY,
            9 => GenerateTimetable::TUESDAY,
        ]);

        $this->addSubject('Physics', 10, [
            1 => GenerateTimetable::THURSDAY,
            2 => GenerateTimetable::THURSDAY,
            3 => GenerateTimetable::THURSDAY,

            4 => GenerateTimetable::WEDNESDAY,
            5 => GenerateTimetable::WEDNESDAY,
            6 => GenerateTimetable::WEDNESDAY,
            7 => GenerateTimetable::WEDNESDAY,
        ]);

        $this->addSubject('Physics', 10, [
            4 => GenerateTimetable::FRIDAY,
            5 => GenerateTimetable::FRIDAY,
            6 => GenerateTimetable::FRIDAY,
            7 => GenerateTimetable::FRIDAY,
        ]);
    }

    /**
     * @return void
     */
    private function upperFifth(): void
    {
        // Year 11 Science Sets
        $this->addSubject('Biology', 11, [
            1 => GenerateTimetable::MONDAY,
            2 => GenerateTimetable::MONDAY,
            3 => GenerateTimetable::MONDAY,
            4 => GenerateTimetable::MONDAY,
            5 => GenerateTimetable::MONDAY,
            6 => GenerateTimetable::MONDAY,
            7 => GenerateTimetable::MONDAY,
            8 => GenerateTimetable::MONDAY,
        ]);

        $this->addSubject('Biology', 11, [
            1 => GenerateTimetable::WEDNESDAY,
            2 => GenerateTimetable::WEDNESDAY,
            3 => GenerateTimetable::WEDNESDAY,
            4 => GenerateTimetable::THURSDAY,
            5 => GenerateTimetable::THURSDAY,
            6 => GenerateTimetable::THURSDAY,
        ]);

        $this->addSubject('Chemistry', 11, [
            1 => GenerateTimetable::WEDNESDAY,
            2 => GenerateTimetable::WEDNESDAY,
            3 => GenerateTimetable::WEDNESDAY,
            4 => GenerateTimetable::WEDNESDAY,
            5 => GenerateTimetable::WEDNESDAY,
            6 => GenerateTimetable::WEDNESDAY,
            7 => GenerateTimetable::MONDAY,
            8 => GenerateTimetable::MONDAY,

        ]);

        $this->addSubject('Chemistry', 11, [
            1 => GenerateTimetable::THURSDAY,
            2 => GenerateTimetable::THURSDAY,
            3 => GenerateTimetable::THURSDAY,
            4 => GenerateTimetable::THURSDAY,
            5 => GenerateTimetable::THURSDAY,
            6 => GenerateTimetable::THURSDAY,
        ]);

        $this->addSubject('Physics', 11, [
            1 => GenerateTimetable::MONDAY,
            2 => GenerateTimetable::MONDAY,
            3 => GenerateTimetable::MONDAY,
            4 => GenerateTimetable::MONDAY,
            5 => GenerateTimetable::MONDAY,
            6 => GenerateTimetable::MONDAY,
        ]);

        $this->addSubject('Physics', 11, [
            1 => GenerateTimetable::THURSDAY,
            2 => GenerateTimetable::THURSDAY,
            3 => GenerateTimetable::THURSDAY,
            4 => GenerateTimetable::WEDNESDAY,
            5 => GenerateTimetable::WEDNESDAY,
            6 => GenerateTimetable::WEDNESDAY,
            7 => GenerateTimetable::THURSDAY,
            8 => GenerateTimetable::THURSDAY,
        ]);
    }
}
