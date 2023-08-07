<?php

namespace App\Logic\SetMappers;

interface SetMapperInterface
{
    public function __construct(string $code, string $subject);

    public function handle(?int $year): int|string;
}
