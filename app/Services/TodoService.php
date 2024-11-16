<?php

namespace App\Services;

use App\Dto\CreateTodoDto;
use App\Dto\UpdateTodoDto;
use App\Models\Todo;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TodoService
{
    public function store(CreateTodoDto $createTodoDto): Todo
    {
        $todo = new Todo;
        $todo->name = $createTodoDto->name;
        $todo->save();

        return $todo;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function update(int $id, UpdateTodoDto $updateTodoDto): Todo
    {
        $todo = Todo::findOrFail($id);

        if ($updateTodoDto->name) {
            $todo->name = $updateTodoDto->name;
        }

        if ($updateTodoDto->status !== null) {
            $todo->status = $updateTodoDto->status;
        }

        if ($todo->isDirty()) {
            $todo->save();
        }

        return $todo;
    }
}
