<?php

namespace App\Logic\SetMappers;

use Exception;

interface SetMapperInterface
{
    public function __construct(string $code, string $subject);

    public function handle(?int $year): int|string;
}
