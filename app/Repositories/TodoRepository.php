<?php

namespace App\Repositories;

use App\Models\Todo;

class TodoRepository
{
    public function getTodos(array $filters, string $sortField, string $sortOrder, int $limit, int $page)
{
    $query = Todo::query();

    if (!empty($filters['status'])) {
        $query->where('status', $filters['status']);
    }

    if (!empty($filters['priority'])) {
        $query->where('priority', $filters['priority']);
    }

    if (!empty($filters['search'])) {
        $query->where('title', 'like', '%' . $filters['search'] . '%');
    }

    return $query->orderBy($sortField, $sortOrder)
                 ->paginate($limit, ['*'], 'page', $page);
}

    public function create(array $data)
    {
        return Todo::create($data);
    }

    public function update(Todo $todo, array $data)
    {
        $todo->update($data);
        return $todo;
    }

        public function findOrFail(int $id): Todo
    {
        $todo = Todo::with('categories')->find($id);

        if (!$todo) {
            throw new \Exception("Todo bulunamadı");
        }

        return $todo;
    }

    public function findById(int $id): Todo
    {
        return Todo::with('categories')->findOrFail($id);
    }

    public function delete(Todo $todo): bool
    {
        return $todo->delete();
    }
}