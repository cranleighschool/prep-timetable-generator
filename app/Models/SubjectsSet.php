<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubjectsSet extends Model
{
    /**
     * @var string
     */
    protected $table = 'set_subject_days';

    public static function label(string $code, bool $raw = false): string
    {
        $label = '';
        $e = explode('-', $code);
        if (Str::endsWith($e[0], 'A')) {
            $label = 'Option A';
        }
        if (Str::endsWith($e[0], 'B')) {
            $label = 'Option B';
        }
        if (Str::endsWith($e[0], 'C')) {
            $label = 'Option C';
        }
        if (Str::endsWith($e[0], 'D')) {
            $label = 'Option D';
        }
        if (Str::endsWith($e[0], 'E')) {
            $label = 'Option E';
        }
        if (preg_match('^\A(9)-(PH|CH|BI)[0-9]{1}\Z^', $code, $matches)) {
            $label = 'Science Set: '.substr($matches[0], -1);
        }
        if (preg_match('^\A(10|11)-(PH)[0-9]{1}\Z^', $code, $matches)) {
            $label = 'Physics Set: '.substr($matches[0], -1);
        }
        if (preg_match('^\A(10|11)-(CH)[0-9]{1}\Z^', $code, $matches)) {
            $label = 'Chemistry Set: '.substr($matches[0], -1);
        }
        if (preg_match('^\A(10|11)-(Bi|BI)[0-9]{1}\Z^', $code, $matches)) {
            $label = 'Biology Set: '.substr($matches[0], -1);
        }
        if (preg_match('^\A(9|10|11)-(FR|SP)[0-9]{1}\Z^', $code, $matches)) {
            $label = 'Language';
        }
        if (preg_match('^\A(9|10|11)-(EN)[0-9]{1}\Z^', $code, $matches)) {
            $label = 'English';
        }
        if (preg_match('^\A(9)-(CC)[0-9]{1}\Z^', $code, $matches)) {
            $label = 'Class Civ Set: '.substr($matches[0], -1);
        }
        if (preg_match('^\A(9)-(GG|HI|RS)[0-9]{1}\Z^', $code, $matches)) {
            $label = 'Humanities Set: '.substr($matches[0], -1);
        }
        if (preg_match('^\A(9|11)-(MA)+(.*)^', $code, $matches)) {
            if ($matches) {
                $label = 'Maths Set: '.trim(end($matches));
            }
        }

        if ($raw) {
            return $label;
        }

        return '<span class="badge bg-success">'.$label.'</span>';
    }
}
