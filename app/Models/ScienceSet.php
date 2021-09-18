<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ScienceSet extends Model
{
    use HasFactory;

    public static function label(string $code)
    {
        $label = '';
        $e = explode("-", $code);
        if (Str::endsWith($e[0], "A")) {
            $label = "Option A";
        }
        if (Str::endsWith($e[0], "B")) {
            $label = "Option B";
        }
        if (Str::endsWith($e[0], "C")) {
            $label = "Option C";
        }
        if (Str::endsWith($e[0], "D")) {
            $label = "Option D";
        }
        if (preg_match('^\A[0-9]{1,2}-(PH|CH|BI)[0-9]{1}\Z^', $code, $matches)) {
            $label = "Science Set: ".substr($matches[0], -1);
        }


        if (preg_match('^\A[0-9]{1,2}-(CC)[0-9]{1}\Z^', $code, $matches)) {
            $label = "Class Civ Set: ".substr($matches[0], -1);
        }
        if (preg_match('^\A[0-9]{1,2}-(GG|HI|RS)[0-9]{1}\Z^', $code, $matches)) {
            $label = "Humanities Set: ".substr($matches[0], -1);
        }
        if (preg_match('^\A[0-9]{1,2}-(MA)+(.*)^', $code, $matches)) {
            $label = "Maths Set: ".trim(end($matches));
        }

        return '<span class="badge bg-success">'.$label.'</span>';
    }
}
