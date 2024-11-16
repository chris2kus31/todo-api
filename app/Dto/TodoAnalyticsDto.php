<?php

namespace App\Dto;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class TodoAnalyticsDto extends Data
{
    public function __construct(
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d', timeZone: 'UTC')]
        public Carbon $from,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d', timeZone: 'UTC')]
        public Carbon $to,
    ) {}
}
