<?php

namespace App\Services;

use App\Dto\CreateTodoDto;
use App\Models\Todo;

class TodoService
{
    public function store(CreateTodoDto $createTodoDto): Todo
    {
        $todo = new Todo;
        $todo->name = $createTodoDto->name;
        $todo->save();

        return $todo;
    }
}
