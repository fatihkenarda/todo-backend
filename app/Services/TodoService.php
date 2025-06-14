<?php

namespace App\Services;

use App\Models\Todo;
use App\Repositories\TodoRepository;

class TodoService
{
    protected TodoRepository $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function list(array $filters, string $sortField, string $sortOrder, int $limit, int $page)
{
    $query = Todo::with('categories') // <--- ilişkileri eager load ediyoruz
        ->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status))
        ->when($filters['priority'] ?? null, fn($q, $priority) => $q->where('priority', $priority))
        ->when($filters['search'] ?? null, fn($q, $search) => $q->where('title', 'like', "%{$search}%"))
        ->orderBy($sortField, $sortOrder);

    return $query->paginate($limit, ['*'], 'page', $page);
}

        public function create(array $data)
    {
        $categoryIds = $data['categories'] ?? []; // gelen kategori id dizisini al
        unset($data['categories']); // temizle

        $todo = $this->todoRepository->create($data);

        if (!empty($categoryIds)) {
            $todo->categories()->sync($categoryIds); // eşleştir
        }

        return $todo->load('categories'); // ilişkili verileri de döndür
    }

        public function update(int $id, array $data): Todo
    {
        $todo = $this->todoRepository->findOrFail($id);
        $todo->update($data);

        if (isset($data['category_ids'])) {
            $todo->categories()->sync($data['category_ids']);
        }

        return $todo->load('categories');
    }

    public function find(int $id)
    {
        return $this->todoRepository->findById($id);
    }

    public function updateStatus(int $id, string $status)
    {
        $todo = $this->todoRepository->findById($id);
        $todo->status = $status;
        $todo->save();

        return $todo;
    }

    public function delete(int $id)
    {
        $todo = $this->todoRepository->findById($id);
        return $this->todoRepository->delete($todo);
    }
}