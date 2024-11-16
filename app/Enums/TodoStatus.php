<?php

namespace App\Enums;

enum TodoStatus: int
{
    case Pending = 0;
    case Completed = 1;

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Completed => 'Completed',
        };
    }
}
