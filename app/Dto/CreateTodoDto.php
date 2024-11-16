<?php

namespace App\Dto;

use Spatie\LaravelData\Data;

class CreateTodoDto extends Data
{
    public function __construct(
        public string $name,
    ) {}
}
