<?php

namespace App\Http\Controllers;

use App\Dto\CreateTodoDto;
use App\Dto\UpdateTodoDto;
use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

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

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->todoService->destroy($id);

            return response()->json(status: HttpResponse::HTTP_NO_CONTENT);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function analytics(Request $request)
    {
        //
    }
}
