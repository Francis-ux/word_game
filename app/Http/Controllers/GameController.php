<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    public function index()
    {
        return view('game');
    }

    public function getWords()
    {
        try {
            $words = Word::inRandomOrder()->take(10)->pluck('word');
            if ($words->isEmpty()) {
                return response()->json(['error' => 'No words available'], 404);
            }
            return response()->json($words);
        } catch (\Exception $e) {
            Log::error('Error fetching words: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function storeScore(Request $request)
    {
        try {
            $validated = $request->validate([
                'player_name' => 'required|string|max:255',
                'score' => 'required|integer|min:0',
                'accuracy' => 'required|numeric|min:0|max:100',
                'wpm' => 'required|numeric|min:0',
            ]);

            $leaderboard = Leaderboard::create($validated);
            return response()->json(['success' => true, 'leaderboard' => $leaderboard], 201);
        } catch (\Exception $e) {
            Log::error('Error saving score: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to save score'], 500);
        }
    }

    public function leaderboard()
    {
        try {
            $scores = Leaderboard::orderBy('score', 'desc')->take(10)->get();
            return response()->json($scores);
        } catch (\Exception $e) {
            Log::error('Error fetching leaderboard: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
}
