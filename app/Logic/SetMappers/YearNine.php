<?php

namespace App\Logic\SetMappers;

use Exception;
use Illuminate\Support\Str;

class YearNine extends AbstractMapper implements SetMapperInterface
{
    /**
     * @throws Exception
     */
    public function handle(?int $year = null): int|string
    {
        $code = $this->code;
        $subject = $this->subject;

        // Latin
        if (in_array($code, ['9A/La1', '9A/La2'])) {
            return 'Latin';
        }

        // OPTIONS
        if (Str::startsWith($code, '9A') && ! Str::contains($code, ['Gg', 'Cc', 'Hi', 'Rs', 'La', 'En'])) {
            return 'Option A';
        }
        if (Str::startsWith($code, '9B') && ! Str::contains($code, ['Gg', 'Cc', 'Hi', 'Rs', 'La', 'En'])) {
            return 'Option B';
        }
        if (Str::startsWith($code, '9C')) {
            return 'Option C';
        }
        if (Str::startsWith($code, '9D')) {
            return 'Option D';
        }

        // Sciences
        if (Str::contains($code, ['Bi', 'Ch', 'Ph'])) {
            // Converts: 9.1/Bi to 1
            return (int) substr($code, 2, 1);
        }

        // Maths
        if (Str::endsWith($code, 'Ma')) {
            // Converts, 9Y1/Ma to Y1
            return (int) substr($code, 2, 1);
        }

        ////         English
        //        if (Str::contains($code, 'En')) {
        //            return substr($code, 1, 1).substr($code, -1, 1);
        //        }

        // Humanities
        if (preg_match('^\A9(a|b|A|B)/(Hi|Cc|Gg|Rs|En)[0-9]{1}\Z^', $code, $matches)) {
            // Is humanity
            return strtolower(substr($code, 1, 1).substr($code, -1, 1));
        }
        // Languages
        if (Str::endsWith($code, 'Fr') || Str::endsWith($code, 'Sp')) {
            return 'CMFL';
        }

        if (in_array($subject, [
            'Latin',
            'Philosophy',
            'Digital Literacy',
        ])) {
            return (int) substr($code, -1, 1);
        }

        throw new Exception('Something went wrong, could not match year 9 subject: '.$subject);
    }
}
