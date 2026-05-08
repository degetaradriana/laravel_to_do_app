<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TodoController extends Controller
{
    public function index()
    {
        $todos = auth()->user()->todos()->latest()->get();
        return view('todos.index', compact('todos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:10240',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('todo-images', 'public');
        }

        auth()->user()->todos()->create([
            'title' => $request->title,
            'image' => $imagePath,
        ]);

        return redirect()->route('todos.index')->with('status', 'Todo adăugat!');
    }

    public function destroy(Todo $todo)
    {
        if ($todo->image) {
            Storage::disk('public')->delete($todo->image);
        }
        $todo->delete();
        return redirect()->route('todos.index')->with('status', 'Todo șters!');
    }
}
