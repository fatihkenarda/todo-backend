<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StatsController;

// API middleware grubunda rate limiting (10 istek/dakika)
Route::middleware(['throttle:60,1', 'api'])->group(function () {

    Route::apiResource('categories', CategoryController::class);
    //Yeni tüm verileri dönen endpoint
    Route::get('/todos/all', [TodoController::class, 'all']);

    // Yaklaşan bitiş tarihleri olanlar
    Route::get('/todos/upcoming', [TodoController::class, 'upcoming']);

    // todos tablosundaki statü sayılarını dönecek
    Route::get('/todos/statistics', [TodoController::class, 'statistics']);

    // Todos resource route (index, show, store, update, destroy vs hepsi)
    Route::apiResource('todos', TodoController::class);

    // Özel endpoint - status güncelleme
    Route::patch('todos/{id}/status', [TodoController::class, 'updateStatus']);

    // Todo arama endpointi
    Route::get('todos/search', [TodoController::class, 'search']);

    // Categories routes
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('{id}', [CategoryController::class, 'show']);
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('{id}', [CategoryController::class, 'update']);
        Route::delete('{id}', [CategoryController::class, 'destroy']);
        Route::get('{id}/todos', [CategoryController::class, 'todos']);
    });

    // İstatistik endpointleri
    Route::get('stats/todos', [StatsController::class, 'todoStatusStats']);
    Route::get('stats/priorities', [StatsController::class, 'priorityStats']);

});