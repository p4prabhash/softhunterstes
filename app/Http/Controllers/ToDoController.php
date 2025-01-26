<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ToDo;

class ToDoController extends Controller
{
    public function dashboard()
    {
        $todos = auth()->user()->todos()->with('category')->get();
        $categories = Category::all();
        return view('user.dashboard', compact('todos', 'categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'task' => 'required',
        'category_id' => 'required|exists:categories,id',
    ]);

    $todo = auth()->user()->todos()->create($request->all());

    return response()->json([
        'id' => $todo->id,
        'task' => $todo->task,
        'category_name' => $todo->category->name,
        'created_at' => $todo->created_at->format('d M Y'),
    ]);
}

public function destroy($id)
{
    $todo = auth()->user()->todos()->findOrFail($id);
    $todo->delete();

    return response()->json(['message' => 'Task deleted successfully']);
}


}
