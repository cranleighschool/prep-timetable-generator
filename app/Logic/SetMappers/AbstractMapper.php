<?php

namespace App\Logic\SetMappers;

abstract class AbstractMapper
{
    public function __construct(protected string $code, protected string $subject)
    {
    }
}
