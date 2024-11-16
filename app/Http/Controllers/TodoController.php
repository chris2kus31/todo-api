<?php

namespace App\Http\Controllers;

use App\Dto\CreateTodoDto;
use App\Dto\UpdateTodoDto;
use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function __construct(
        private readonly TodoService $todoService,
    ) {}

    public function index()
    {
        //
    }

    public function store(CreateTodoDto $createTodoDto): Todo
    {
        return $this->todoService->store($createTodoDto);
    }

    public function show(int $id): Todo
    {
        return $this->todoService->show($id);
    }

    public function update(UpdateTodoDto $updateTodoDto, int $id): Todo
    {
        return $this->todoService->update($id, $updateTodoDto);
    }

    public function destroy(string $id)
    {
        //
    }

    public function analytics(Request $request)
    {
        //
    }
}
