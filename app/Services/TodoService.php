<?php

namespace App\Services;

use App\Dto\CreateTodoDto;
use App\Dto\UpdateTodoDto;
use App\Models\Todo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\LaravelData\Optional;

class TodoService
{
    public function show(int $id): Todo
    {
        return Todo::findOrFail($id);
    }

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

        if (! $updateTodoDto->name instanceof Optional) {
            $todo->name = $updateTodoDto->name;
        }

        if (! $updateTodoDto->status instanceof Optional) {
            $todo->status = $updateTodoDto->status;
        }

        if ($todo->isDirty()) {
            $todo->save();
        }

        return $todo;
    }

    public function destroy(int $id): bool
    {
        $todo = Todo::find($id);
        if (null === $todo) {
            return true;
        }

        $todo->delete();

        return true;
    }
}
