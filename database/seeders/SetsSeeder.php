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
     */
    public function run(): void
    {
        $this->fourthForm();
        $this->lowerFifth();
        $this->upperFifth();
    }

    private function fourthForm(): void
    {
        //        $this->setsBySubjectToday('English', 9, GenerateTimetable::TUESDAY, [
        //            5, 6, 7, 8,
        //        ]);
        //
        //        $this->setsBySubjectToday('English', 9, GenerateTimetable::FRIDAY, [
        //            1, 2, 3, 4,
        //        ]);

        DB::table('set_subject_days')->insert([

            $this->getData(1, 'Biology', GenerateTimetable::MONDAY),
            $this->getData(1, 'Chemistry', GenerateTimetable::TUESDAY),
            $this->getData(1, 'Physics', GenerateTimetable::WEDNESDAY),

            $this->getData(2, 'Biology', GenerateTimetable::WEDNESDAY),
            $this->getData(2, 'Chemistry', GenerateTimetable::TUESDAY),
            $this->getData(2, 'Physics', GenerateTimetable::MONDAY),

            $this->getData(3, 'Biology', GenerateTimetable::TUESDAY),
            $this->getData(3, 'Chemistry', GenerateTimetable::WEDNESDAY),
            $this->getData(3, 'Physics', GenerateTimetable::MONDAY),

            $this->getData(4, 'Biology', GenerateTimetable::WEDNESDAY),
            $this->getData(4, 'Chemistry', GenerateTimetable::TUESDAY),
            $this->getData(4, 'Physics', GenerateTimetable::MONDAY),

            $this->getData(5, 'Biology', GenerateTimetable::MONDAY),
            $this->getData(5, 'Chemistry', GenerateTimetable::WEDNESDAY),
            $this->getData(5, 'Physics', GenerateTimetable::TUESDAY),

            $this->getData(6, 'Biology', GenerateTimetable::TUESDAY),
            $this->getData(6, 'Chemistry', GenerateTimetable::WEDNESDAY),
            $this->getData(6, 'Physics', GenerateTimetable::MONDAY),

            $this->getData(7, 'Biology', GenerateTimetable::WEDNESDAY),
            $this->getData(7, 'Chemistry', GenerateTimetable::TUESDAY),
            $this->getData(7, 'Physics', GenerateTimetable::MONDAY),
            //
            //            $this->getData(8, 'Biology', GenerateTimetable::MONDAY),
            //            $this->getData(8, 'Chemistry', GenerateTimetable::THURSDAY),
            //            $this->getData(8, 'Physics', GenerateTimetable::FRIDAY),
        ]);
        $this->addSubject('Class Civ', 9, [
            'a1' => GenerateTimetable::MONDAY,
            'a2' => GenerateTimetable::MONDAY,
            'a3' => GenerateTimetable::MONDAY,
            'a4' => GenerateTimetable::MONDAY,
            'b1' => GenerateTimetable::FRIDAY,
            'b2' => GenerateTimetable::WEDNESDAY,
            'b3' => GenerateTimetable::FRIDAY,
            'b4' => GenerateTimetable::MONDAY,
        ]);
        $this->addSubject('Geography', 9, [
            'a1' => GenerateTimetable::FRIDAY,
            'a2' => GenerateTimetable::FRIDAY,
            'a3' => GenerateTimetable::WEDNESDAY,
            'a4' => GenerateTimetable::FRIDAY,
            'b1' => GenerateTimetable::WEDNESDAY,
            'b2' => GenerateTimetable::MONDAY,
            'b3' => GenerateTimetable::MONDAY,
            'b4' => GenerateTimetable::FRIDAY,
        ]);
        $this->addSubject('History', 9, [
            'a1' => GenerateTimetable::FRIDAY,
            'a2' => GenerateTimetable::FRIDAY,
            'a3' => GenerateTimetable::FRIDAY,
            'a4' => GenerateTimetable::WEDNESDAY,
            'b1' => GenerateTimetable::FRIDAY,
            'b2' => GenerateTimetable::FRIDAY,
            'b3' => GenerateTimetable::FRIDAY,
            'b4' => GenerateTimetable::WEDNESDAY,
        ]);
        $this->addSubject('RS', 9, [
            'a1' => GenerateTimetable::WEDNESDAY,
            'a2' => GenerateTimetable::WEDNESDAY,
            'a3' => GenerateTimetable::FRIDAY,
            'a4' => GenerateTimetable::FRIDAY,
            'b1' => GenerateTimetable::MONDAY,
            'b2' => GenerateTimetable::FRIDAY,
            'b3' => GenerateTimetable::WEDNESDAY,
            'b4' => GenerateTimetable::FRIDAY,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function getData(int|string $set, string $subject, string $day, int $yearGroup = 9): array
    {
        $day_id = PrepDay::query()->where('day', '=', $day)->first()?->id;

        return [
            'set' => $set,
            'subject' => $subject,
            'day_id' => $day_id,
            'nc_year' => $yearGroup,
        ];
    }

    /**
     * @param array<array-key, string> $array
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
     * @param array<array-key, string> $sets
     */
    private function setsBySubjectToday(string $subject, int $yearGroup, string $day, array $sets): void
    {
        $array = [];
        foreach ($sets as $set) {
            $array[$set] = $day;
        }
        $this->addSubject($subject, $yearGroup, $array);
    }

    private function lowerFifth(): void
    {
        $this->setsBySubjectToday('Chemistry', 10, GenerateTimetable::MONDAY, [
            'T1', 'T2', 'T3'
        ]);

        $this->setsBySubjectToday('Biology', 10, GenerateTimetable::MONDAY, [
            'T4', 'T5', 'D91', 'D92',
        ]);

        $this->setsBySubjectToday('Chemistry', 10, GenerateTimetable::MONDAY, [
            'D6',
        ]);

        //TUESDAY
        $this->setsBySubjectToday('Biology', 10, GenerateTimetable::TUESDAY, [
            'T1', 'T2', 'T3', 'D92',
        ]);

        $this->setsBySubjectToday('Physics', 10, GenerateTimetable::TUESDAY, [
            'T4', 'T5', 'D91',
        ]);

        // WEDNESDAY
        $this->setsBySubjectToday('Physics', 10, GenerateTimetable::WEDNESDAY, [
            'T1', 'T2', 'T3', 'D6',
        ]);
        $this->setsBySubjectToday('Chemistry', 10, GenerateTimetable::WEDNESDAY, [
            'T4', 'T5', 'D91', 'D92',
        ]);

        // THURSDAY
        $this->setsBySubjectToday('Biology', 10, GenerateTimetable::THURSDAY, [
            'T1', 'T2', 'T3'
        ]);
        $this->setsBySubjectToday('Chemistry', 10, GenerateTimetable::THURSDAY, [
            'T4', 'T5', 'D91', 'D92',
        ]);

        // FRIDAY
        $this->setsBySubjectToday('Chemistry', 10, GenerateTimetable::FRIDAY, [
            'T1', 'T2', 'T3'
        ]);
        $this->setsBySubjectToday('Biology', 10, GenerateTimetable::FRIDAY, [
            'T4', 'T5', 'D91', 'D6'
        ]);
        $this->setsBySubjectToday('Physics', 10, GenerateTimetable::FRIDAY, [
            'D92',
        ]);
    }

    private function upperFifth(): void
    {
        $this->setsBySubjectToday('Biology', 11, GenerateTimetable::MONDAY, [
            'T1', 'T2', 'T3',
        ]);

        $this->setsBySubjectToday('Biology', 11, GenerateTimetable::WEDNESDAY, [
            'T1', 'T2', 'T3',
        ]);

        $this->setsBySubjectToday('Biology', 11, GenerateTimetable::THURSDAY, [
            'T4', 'T5', 'D9',
        ]);

        $this->setsBySubjectToday('Biology', 11, GenerateTimetable::FRIDAY, [
            'D6', 'D9', 'T4', 'T5',
        ]);

        $this->setsBySubjectToday('Chemistry', 11, GenerateTimetable::TUESDAY, [
            'T4', 'T5', 'D9',
        ]);
        $this->setsBySubjectToday('Chemistry', 11, GenerateTimetable::WEDNESDAY, [
            'T4', 'T5', 'D9',
        ]);
        $this->setsBySubjectToday('Chemistry', 11, GenerateTimetable::THURSDAY, [
            'T1', 'T2', 'T3',
        ]);
        $this->setsBySubjectToday('Chemistry', 11, GenerateTimetable::FRIDAY, [
            'D6', 'T1', 'T2', 'T3',
        ]);

        $this->setsBySubjectToday('Physics', 11, GenerateTimetable::MONDAY, [
            'T4', 'T5', 'D9',
        ]);
        $this->setsBySubjectToday('Physics', 11, GenerateTimetable::TUESDAY, [
            'T1', 'T2', 'T3',
        ]);
        $this->setsBySubjectToday('Physics', 11, GenerateTimetable::THURSDAY, [
            'D6',
        ]);
        $this->setsBySubjectToday('Physics', 11, GenerateTimetable::FRIDAY, [
            'T1', 'T2', 'T3', 'T4', 'T5', 'D9',
        ]);
    }
}
