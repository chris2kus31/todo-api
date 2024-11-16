<?php

namespace App\Models;

use App\Enums\TodoStatus;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    /**
     * The name of the "updated at" column.
     *
     * Set to `null` to disable updates for the updated_at column.
     */
    const UPDATED_AT = null;

    protected $attributes = [
        'status' => TodoStatus::Pending,
        'completed_at' => null,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => TodoStatus::class,
            'created_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public static function countByDtRange(
        DateTime $from,
        DateTime $to,
    ): int {
        return self::whereBetween('created_at', [
            $from->format('Y-m-d'),
            $to->format('Y-m-d'),
        ])->count();
    }

    public static function doneCountByDtRange(
        DateTime $from,
        DateTime $to,
    ): int {
        return self::whereBetween('completed_at', [
            $from->format('Y-m-d'),
            $to->format('Y-m-d'),
        ])->count();
    }
}
