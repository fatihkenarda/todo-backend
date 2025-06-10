<?php

namespace App\Http\Controllers;

use App\Models\Todo;

class StatsController extends Controller
{
    // Durum bazında sayım (pending, completed)
    public function todoStatusStats()
    {
        $stats = Todo::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        return response()->json($stats);
    }

    // Öncelik bazında sayım (low, medium, high)
    public function priorityStats()
    {
        $stats = Todo::selectRaw('priority, COUNT(*) as count')
            ->groupBy('priority')
            ->get();

        return response()->json($stats);
    }
}