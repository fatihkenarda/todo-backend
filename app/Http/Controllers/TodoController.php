<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Services\TodoService;
use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    protected TodoService $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function index(Request $request)
    {
    $limit = min(max((int) $request->input('per_page', 10), 1), 50);
    $page = (int) $request->input('page', 1);

    $sortField = in_array($request->input('sort_by'), ['created_at', 'due_date', 'priority', 'title']) ? $request->input('sort_by') : 'created_at';
    $sortOrder = $request->input('sort_order') === 'asc' ? 'asc' : 'desc';

    $filters = $request->only(['status', 'priority', 'search']);

    $paginated = $this->todoService->list($filters, $sortField, $sortOrder, $limit, $page);

        return response()->json([
            'status' => 'success',
            'message' => 'Todo listesi getirildi.',
            'data' => $paginated->items(),
            'meta' => [
                'total' => $paginated->total(),
                'per_page' => $paginated->perPage(),
                'current_page' => $paginated->currentPage(),
                'total_pages' => $paginated->lastPage()
            ],
            'errors' => [],
        ]);
    }

    public function store(StoreTodoRequest $request)
    {
        $todo = $this->todoService->create($request->validated());
        $todo->categories()->sync($request->input('categories', []));
        return response()->json([
            'status' => 'success',
            'message' => 'Todo başarıyla oluşturuldu.',
            'data' => $todo,
            'meta' => null,
            'errors' => [],
        ], 201);
    }

    public function show(int $id)
    {
        $todo = $this->todoService->find($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Todo bulundu.',
            'data' => $todo,
            'meta' => null,
            'errors' => [],
        ]);
    }

    public function update(UpdateTodoRequest $request, int $id)
    {
        $todo = $this->todoService->update($id, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Todo başarıyla güncellendi.',
            'data' => $todo,
            'meta' => null,
            'errors' => [],
        ]);
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,in_progress,completed,cancelled',
        ]);

        $todo = $this->todoService->updateStatus($id, $request->status);

        return response()->json([
            'status' => 'success',
            'message' => 'Todo durumu güncellendi.',
            'data' => $todo,
            'meta' => null,
            'errors' => [],
        ]);
    }

    public function destroy(int $id)
    {
        $this->todoService->delete($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Todo başarıyla silindi.',
            'data' => null,
            'meta' => null,
            'errors' => [],
        ], 204);
    }

        public function upcoming()
    {
        $todos = Todo::whereDate('due_date', '>=', now())
                    ->whereDate('due_date', '<=', now()->addDays(3))
                    ->orderBy('due_date', 'asc')
                    ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Yaklaşan todo\'lar getirildi.',
            'data' => $todos,
            'meta' => null,
            'errors' => [],
        ]);
    }

        public function statistics()
    {
        $data = [
            'pending' => Todo::where('status', 'pending')->count(),
            'in_progress' => Todo::where('status', 'in_progress')->count(),
            'completed' => Todo::where('status', 'completed')->count(),
            'cancelled' => Todo::where('status', 'cancelled')->count(),
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'İstatistikler getirildi.',
            'data' => $data,
            'meta' => null,
            'errors' => [],
        ]);
    }

    public function all()
{
    $todos = Todo::with('categories')->get();  // İlişkili kategorileri de getir
    return response()->json([
        'status' => 'success',
        'message' => 'Tüm görevler getirildi.',
        'data' => $todos
    ]);
}
    
}