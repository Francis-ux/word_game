<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $words = Word::all();
        return view('admin.words', compact('words'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'word' => 'required|string|unique:words,word',
        ]);

        Word::create($validated);
        return redirect()->route('admin.words.index')->with('success', 'Word added successfully.');
    }

    public function destroy($id)
    {
        Word::findOrFail($id)->delete();
        return redirect()->route('admin.words.index')->with('success', 'Word deleted successfully.');
    }
}
