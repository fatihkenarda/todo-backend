<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    // Tüm kategorileri listele
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        return response()->json([
            'status' => 'success',
            'message' => 'Kategoriler listelendi.',
            'data' => $categories,
            'errors' => [],
            'meta' => null,
        ]);
    }

    // Belirli bir kategoriyi getir
    public function show($id)
    {
        try {
            $category = $this->categoryService->getCategory($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Kategori bulundu.',
                'data' => $category,
                'errors' => [],
                'meta' => null,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori bulunamadı.',
                'data' => null,
                'errors' => ['Kategori ID mevcut değil.'],
                'meta' => null,
            ], 404);
        }
    }

    // Yeni bir kategori oluştur
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:50',
        ]);

        $category = $this->categoryService->createCategory($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori oluşturuldu.',
            'data' => $category,
            'errors' => [],
            'meta' => null,
        ], 201);
    }

    // Mevcut bir kategoriyi güncelle
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'color' => 'nullable|string|max:50',
        ]);

        try {
            $category = $this->categoryService->updateCategory($id, $validated);
            return response()->json([
                'status' => 'success',
                'message' => 'Kategori güncellendi.',
                'data' => $category,
                'errors' => [],
                'meta' => null,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori bulunamadı.',
                'data' => null,
                'errors' => ['Kategori ID mevcut değil.'],
                'meta' => null,
            ], 404);
        }
    }

    // Kategoriyi sil
    public function destroy($id)
    {
        try {
            $this->categoryService->deleteCategory($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Kategori silindi.',
                'data' => null,
                'errors' => [],
                'meta' => null,
            ], 204);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori bulunamadı.',
                'data' => null,
                'errors' => ['Kategori ID mevcut değil.'],
                'meta' => null,
            ], 404);
        }
    }

    // Belirli kategoriye ait todo’ları getir
    public function todos($id)
    {
        try {
            $todos = $this->categoryService->getTodosByCategory($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Kategoriye ait todo’lar getirildi.',
                'data' => $todos,
                'errors' => [],
                'meta' => null,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori bulunamadı.',
                'data' => null,
                'errors' => ['Kategori ID mevcut değil.'],
                'meta' => null,
            ], 404);
        }
    }
}