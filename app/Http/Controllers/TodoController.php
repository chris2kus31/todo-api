<?php

namespace App\Http\Controllers;

use App\Dto\CreateTodoDto;
use App\Dto\TodoAnalyticsDto;
use App\Dto\TodoAnalyticsResponseDto;
use App\Dto\TodoListRequestDto;
use App\Dto\UpdateTodoDto;
use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TodoController extends Controller
{
    public function __construct(
        private readonly TodoService $todoService,
    ) {}

    /**
     * Display a paginated list of Todos with optional filters and sorting.
     * Accepts name filter, status filter, sort field, and sort order from TodoListRequestDto.
     */
    public function index(TodoListRequestDto $request): Paginator
    {
        $query = Todo::query();

        // Apply optional filters from the request DTO
        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Apply sorting and pagination using fields from the DTO
        return $query
            ->orderBy($request->sortField, $request->sortOrder->value)
            ->simplePaginate($request->perPage, ['*'], 'page', $request->page);
    }

    /**
     * Store a new To-do item using validated data from CreateTodoDto.
     * Returns the newly created Todo item.
     */
    public function store(CreateTodoDto $createTodoDto): JsonResponse
    {
        try {
            $todo = $this->todoService->store($createTodoDto);
            return response()->json($todo, HttpResponse::HTTP_CREATED);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Failed to create Todo item',
                'message' => $e->getMessage(),
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show a specific To-do item by ID.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $todo = $this->todoService->show($id);
            return response()->json($todo, HttpResponse::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Todo item not found',
                'message' => $e->getMessage(),
            ], HttpResponse::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update a specific To-do item by ID using UpdateTodoDto.
     * Returns the updated To-do item.
     */
    public function update(UpdateTodoDto $updateTodoDto, int $id): JsonResponse
    {
        try {
            $todo = $this->todoService->update($id, $updateTodoDto);
            return response()->json($todo, HttpResponse::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Todo item not found',
                'message' => $e->getMessage(),
            ], HttpResponse::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Failed to update Todo item',
                'message' => $e->getMessage(),
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Delete a specific To-do item by ID.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->todoService->destroy($id);
            return response()->json(null, HttpResponse::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Todo item not found',
                'message' => $e->getMessage(),
            ], HttpResponse::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Failed to delete Todo item',
                'message' => $e->getMessage(),
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function analytics(TodoAnalyticsDto $analyticsDto): JsonResponse
    {
        try {
            // Use the service to get analytics data within the specified date range
            $analyticsData = $this->todoService->analytics($analyticsDto->from, $analyticsDto->to);

            // Wrap the analytics data in TodoAnalyticsResponseDto for a structured response
            $response = new TodoAnalyticsResponseDto(
                created: $analyticsData->created,
                completed: $analyticsData->completed
            );

            return response()->json($response, HttpResponse::HTTP_OK);
        } catch (\Throwable $e) {
            // Return a JSON error response if analytics retrieval fails
            return response()->json([
                'error' => 'Failed to retrieve analytics data',
                'message' => $e->getMessage(),
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
