<?php

namespace App\Dto;

use Spatie\LaravelData\Data;

class TodoAnalyticsResponseDto extends Data
{
    public function __construct(
        public int $created,
        public int $completed,
    ) {}
}
