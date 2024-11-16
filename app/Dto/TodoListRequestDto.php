<?php

namespace App\Dto;

use App\Enums\SortOrder;
use App\Enums\TodoStatus;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;

class TodoListRequestDto extends Data
{
    public function __construct(
        #[MapInputName('filters.name')]
        public ?string $name,

        #[MapInputName('filters.status')]
        public ?TodoStatus $status,

        #[MapInputName('sort.field')]
        #[In(['name', 'status', 'created_at'])]
        public string $sortField = 'created_at',

        #[MapInputName('sort.order')]
        public SortOrder $sortOrder = SortOrder::ASC,

        #[Min(1)]
        public int $page = 1,

        #[Min(1)]
        #[Max(100)]
        public int $perPage = 10,
    ) {}
}
