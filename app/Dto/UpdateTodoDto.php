<?php

namespace App\Dto;

use App\Enums\TodoStatus;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UpdateTodoDto extends Data
{
    public function __construct(
        public string|Optional $name,
        public TodoStatus|Optional $status,
    ) {}
}
