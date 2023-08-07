<?php

namespace App\Logic\SetMappers;

use Exception;
use Illuminate\Support\Str;

class Gcses implements SetMapperInterface
{
    public function __construct(protected string $code, protected string $subject)
    {
    }

    /**
     * @throws Exception
     */
    public function handle(?int $year): int|string
    {
        if ($year !== 10 && $year !== 11) {
            throw new Exception('Year must be 10 or 11');
        }

        $code = $this->code;
        $subject = $this->subject;
        // Sciences
        if (Str::startsWith($code, $year.'D6')) {
            // DAS in 6
            return substr($code, 2, 2);
        }
        if (Str::startsWith($code, $year.'D9')) {
            // DAS in 9
            return substr($code, 2, 2);
        }
        if (Str::startsWith($code, $year.'T')) {
            // Triple Award
            return substr($code, 2, 2);
        }

        // GCSE OPTIONS
        if (Str::startsWith($code, $year.'A')) {
            return 'Option A';
        }
        if (Str::startsWith($code, $year.'B')) {
            return 'Option B';
        }
        if (Str::startsWith($code, $year.'C')) {
            return 'Option C';
        }
        if (Str::startsWith($code, $year.'D')) {
            return 'Option D';
        }

        // MATHS / ENGLISH
        if (in_array($subject, ['Maths', 'English'])) {
            // Converts "103/En" to "3"
            return (int) substr($code, 2, 1);
        }

//        dd($code);
        // CMFL
        if (preg_match('^\A'.$year.'\.?[0-9]/(Fr|Sp)\Z^', $code, $matches)) {
            return 'CMFL';
        }
        if (in_array($subject, [
            'Greek',
            'Philosophy',

        ])) {
            return (int) substr($code, -1, 1);
        }

        throw new Exception('Something went wrong, could not match year 11 subject: '.$subject);
    }
}
