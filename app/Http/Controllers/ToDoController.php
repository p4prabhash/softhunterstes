<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ToDo;
use Illuminate\Support\Facades\DB;

class ToDoController extends Controller
{
    public function dashboard()
    {
        $todos = auth()->user()->todos()->with('category')->get();
        $categories = Category::all();
        $rankings = DB::table('game_scores')
        ->select('display_name', 'score', 'completion_time')
        ->orderBy('score', 'desc')
        ->orderBy('completion_time', 'asc')
        ->orderBy('display_name', 'asc')
        ->get();

    $processedRankings = [];
    $previousScore = null;
    $previousTime = null;
    $previousRank = 0;
    $tieCounter = 0;

    foreach ($rankings as $index => $row) {
        if (
            $row->score === $previousScore &&
            $row->completion_time === $previousTime
        ) {
            $tieCounter++;
            $processedRankings[] = [
                'rank' => "=" . $previousRank,
                'display_name' => $row->display_name,
                'score' => $row->score,
                'completion_time' => $row->completion_time,
            ];
        } else {
            $previousRank = $previousRank + $tieCounter + 1;
            $tieCounter = 0;
            $previousScore = $row->score;
            $previousTime = $row->completion_time;

            $processedRankings[] = [
                'rank' => $previousRank,
                'display_name' => $row->display_name,
                'score' => $row->score,
                'completion_time' => $row->completion_time,
            ];
        }
    }
        return view('user.dashboard', compact('todos', 'categories','processedRankings'));
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
