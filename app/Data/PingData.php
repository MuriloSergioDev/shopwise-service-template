<?php

declare(strict_types=1);

namespace App\Data;

final readonly class PingData
{
    public function __construct(
        public string $message,
    ) {}
}
