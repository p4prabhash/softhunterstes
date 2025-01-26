<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ToDo;

class AdminController extends Controller
{
    public function dashboard()
    {
        $tasks = ToDo::with('user', 'category')->get();
        return view('admin.dashboard', compact('tasks'));
    }

    public function createCategory()
    {
        return view('admin.create-category');
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required']);
        Category::create($request->all());
        return redirect()->route('admin.dashboard')->with('success', 'Category created!');
    }
}
