<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('date', $request->date);
        }

        if ($request->has('priority') && $request->priority != '') {
            $query->where('priority', $request->priority);
        }

        $tasks = $query->where('status', false)->orderBy('date')->get();

        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'priority' => 'required|in:High,Medium,Low',
        ]);

        Task::create([
            'name' => $request->name,
            'date' => $request->date,
            'priority' => $request->priority,
            'status' => false,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, Task $task)
    {
        $task->status = !$task->status;
        $task->save();

        return redirect()->back();
    }

    public function updateFull(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'priority' => 'required|in:High,Medium,Low',
        ]);

        $task->update([
            'name' => $request->name,
            'date' => $request->date,
            'priority' => $request->priority,
        ]);

        return redirect()->back();
    }

    public function finished()
    {
        $tasks = Task::where('status', true)->orderBy('date')->get();
        return view('tasks.finished', compact('tasks'));
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back();
    }
}
