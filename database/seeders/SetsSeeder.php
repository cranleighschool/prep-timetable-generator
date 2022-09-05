<?php

namespace Database\Seeders;

use App\Logic\GenerateTimetable;
use App\Models\PrepDay;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SetsSeeder extends Seeder
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
        $this->setsBySubjectToday('English', 9, GenerateTimetable::TUESDAY, [
            5, 6, 7, 8,
        ]);

        $this->setsBySubjectToday('English', 9, GenerateTimetable::FRIDAY, [
            1, 2, 3, 4,
        ]);

        DB::table('set_subject_days')->insert([

            $this->getData(1, 'Biology', GenerateTimetable::TUESDAY),
            $this->getData(1, 'Chemistry', GenerateTimetable::THURSDAY),
            $this->getData(1, 'Physics', GenerateTimetable::MONDAY),

            $this->getData(2, 'Biology', GenerateTimetable::TUESDAY),
            $this->getData(2, 'Chemistry', GenerateTimetable::MONDAY),
            $this->getData(2, 'Physics', GenerateTimetable::THURSDAY),

            $this->getData(3, 'Biology', GenerateTimetable::TUESDAY),
            $this->getData(3, 'Chemistry', GenerateTimetable::MONDAY),
            $this->getData(3, 'Physics', GenerateTimetable::THURSDAY),

            $this->getData(4, 'Biology', GenerateTimetable::MONDAY),
            $this->getData(4, 'Chemistry', GenerateTimetable::THURSDAY),
            $this->getData(4, 'Physics', GenerateTimetable::TUESDAY),

            $this->getData(5, 'Biology', GenerateTimetable::THURSDAY),
            $this->getData(5, 'Chemistry', GenerateTimetable::MONDAY),
            $this->getData(5, 'Physics', GenerateTimetable::FRIDAY),

            $this->getData(6, 'Biology', GenerateTimetable::THURSDAY),
            $this->getData(6, 'Chemistry', GenerateTimetable::MONDAY),
            $this->getData(6, 'Physics', GenerateTimetable::FRIDAY),

            $this->getData(7, 'Biology', GenerateTimetable::MONDAY),
            $this->getData(7, 'Chemistry', GenerateTimetable::FRIDAY),
            $this->getData(7, 'Physics', GenerateTimetable::THURSDAY),

            $this->getData(8, 'Biology', GenerateTimetable::FRIDAY),
            $this->getData(8, 'Chemistry', GenerateTimetable::THURSDAY),
            $this->getData(8, 'Physics', GenerateTimetable::MONDAY),
        ]);
        $this->addSubject('Class Civ', 9, [
//            'a1' => GenerateTimetable::FRIDAY,
//            'a2' => GenerateTimetable::FRIDAY,
            'b1' => GenerateTimetable::FRIDAY,
            'b2' => GenerateTimetable::WEDNESDAY,
            'b3' => GenerateTimetable::WEDNESDAY,
            'b4' => GenerateTimetable::THURSDAY,
        ]);
        $this->addSubject('Geography', 9, [
            'a1' => GenerateTimetable::WEDNESDAY,
            'a2' => GenerateTimetable::MONDAY,
            'a3' => GenerateTimetable::MONDAY,
            'a4' => GenerateTimetable::THURSDAY,
            'b1' => GenerateTimetable::THURSDAY,
            'b2' => GenerateTimetable::FRIDAY,
            'b3' => GenerateTimetable::FRIDAY,
            'b4' => GenerateTimetable::FRIDAY,
        ]);
        $this->addSubject('History', 9, [
            'a1' => GenerateTimetable::THURSDAY,
            'a2' => GenerateTimetable::WEDNESDAY,
            'a3' => GenerateTimetable::THURSDAY,
            'a4' => GenerateTimetable::WEDNESDAY,
            'b1' => GenerateTimetable::WEDNESDAY,
            'b2' => GenerateTimetable::THURSDAY,
            'b3' => GenerateTimetable::THURSDAY,
            'b4' => GenerateTimetable::FRIDAY,
        ]);
        $this->addSubject('RS', 9, [
            'a1' => GenerateTimetable::MONDAY,
            'a2' => GenerateTimetable::THURSDAY,
            'a3' => GenerateTimetable::WEDNESDAY,
            'a4' => GenerateTimetable::MONDAY,
            'b1' => GenerateTimetable::FRIDAY,
            'b2' => GenerateTimetable::FRIDAY,
            'b3' => GenerateTimetable::FRIDAY,
            'b4' => GenerateTimetable::WEDNESDAY,
        ]);
    }

    /**
     * @param  string  $set
     * @param  string  $subject
     * @param  string  $day
     * @param  int  $yearGroup
     * @return array
     */
    private function getData(string $set, string $subject, string $day, int $yearGroup = 9): array
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
     * @return void
     */
    private function addSubject(string $subject, int $yearGroup, array $array): void
    {
        foreach ($array as $set => $day) {
            DB::table('set_subject_days')->insert([
                $this->getData($set, $subject, $day, $yearGroup),
            ]);
        }
    }

    /**
     * @param  string  $subject
     * @param  int  $yearGroup
     * @param  string  $day
     * @param  array  $sets
     * @return void
     */
    private function setsBySubjectToday(string $subject, int $yearGroup, string $day, array $sets): void
    {
        $array = [];
        foreach ($sets as $set) {
            $array[$set] = $day;
        }
        $this->addSubject($subject, $yearGroup, $array);
    }

    /**
     * @return void
     */
    private function lowerFifth(): void
    {
        $this->setsBySubjectToday('Biology', 10, GenerateTimetable::MONDAY, [
            'T1', 'T2', 'T3',
        ]);
        $this->setsBySubjectToday('Chemistry', 10, GenerateTimetable::MONDAY, [
            'T4', 'T5', 'D9',
        ]);
        $this->setsBySubjectToday('Chemistry', 10, GenerateTimetable::TUESDAY, [
            'T1', 'T2', 'T3',
        ]);
        $this->setsBySubjectToday('Biology', 10, GenerateTimetable::TUESDAY, [
            'T4', 'T5', 'D9',
        ]);
        $this->setsBySubjectToday('Chemistry', 10, GenerateTimetable::WEDNESDAY, [
            'T1', 'T2', 'T3',
        ]);
        $this->setsBySubjectToday('Physics', 10, GenerateTimetable::WEDNESDAY, [
            'T4', 'T5', 'D9',
        ]);
        $this->setsBySubjectToday('Biology', 10, GenerateTimetable::WEDNESDAY, [
            'D6',
        ]);
        $this->setsBySubjectToday('Biology', 10, GenerateTimetable::THURSDAY, [
            'T1', 'T2', 'T3',
        ]);
        $this->setsBySubjectToday('Chemistry', 10, GenerateTimetable::THURSDAY, [
            'T4', 'T5', 'D9',
        ]);
        $this->setsBySubjectToday('Physics', 10, GenerateTimetable::THURSDAY, [
            'D6',
        ]);
        $this->setsBySubjectToday('Physics', 10, GenerateTimetable::FRIDAY, [
            'T1', 'T2', 'T3',
        ]);
        $this->setsBySubjectToday('Biology', 10, GenerateTimetable::FRIDAY, [
            'T4', 'T5', 'D9',
        ]);
        $this->setsBySubjectToday('Chemistry', 10, GenerateTimetable::FRIDAY, [
            'D6',
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
        ]);

        $this->addSubject('Biology', 11, [
            1 => GenerateTimetable::WEDNESDAY,
            2 => GenerateTimetable::WEDNESDAY,
            3 => GenerateTimetable::WEDNESDAY,
            8 => GenerateTimetable::WEDNESDAY,
            9 => GenerateTimetable::WEDNESDAY,
        ]);
        $this->addSubject('Biology', 11, [
            4 => GenerateTimetable::FRIDAY,
            5 => GenerateTimetable::FRIDAY,
            6 => GenerateTimetable::FRIDAY,
            7 => GenerateTimetable::FRIDAY,
        ]);

        $this->addSubject('Chemistry', 11, [
            1 => GenerateTimetable::MONDAY,
            2 => GenerateTimetable::MONDAY,
            3 => GenerateTimetable::MONDAY,
            4 => GenerateTimetable::WEDNESDAY,
            5 => GenerateTimetable::WEDNESDAY,
            6 => GenerateTimetable::WEDNESDAY,
            7 => GenerateTimetable::WEDNESDAY,
            8 => GenerateTimetable::WEDNESDAY,
            9 => GenerateTimetable::WEDNESDAY,

        ]);

        $this->addSubject('Chemistry', 11, [
            1 => GenerateTimetable::FRIDAY,
            2 => GenerateTimetable::FRIDAY,
            3 => GenerateTimetable::FRIDAY,
            4 => GenerateTimetable::THURSDAY,
            5 => GenerateTimetable::THURSDAY,
            6 => GenerateTimetable::THURSDAY,
            7 => GenerateTimetable::THURSDAY,
        ]);

        $this->addSubject('Physics', 11, [
            4 => GenerateTimetable::MONDAY,
            5 => GenerateTimetable::MONDAY,
            6 => GenerateTimetable::MONDAY,
            7 => GenerateTimetable::MONDAY,
            8 => GenerateTimetable::MONDAY,
            9 => GenerateTimetable::MONDAY,
            1 => GenerateTimetable::THURSDAY,
            2 => GenerateTimetable::THURSDAY,
            3 => GenerateTimetable::THURSDAY,
        ]);

        $this->addSubject('Physics', 11, [
            1 => GenerateTimetable::WEDNESDAY,
            2 => GenerateTimetable::WEDNESDAY,
            3 => GenerateTimetable::WEDNESDAY,
            4 => GenerateTimetable::WEDNESDAY,
            5 => GenerateTimetable::WEDNESDAY,
            6 => GenerateTimetable::WEDNESDAY,
            7 => GenerateTimetable::THURSDAY,
        ]);
    }
}
