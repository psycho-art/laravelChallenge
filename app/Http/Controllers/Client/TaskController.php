<?php

namespace App\Http\Controllers\Client;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $title = "Tasks";

        try {
            // Get filters
            $status = $request->get('status');

            // Build query with optional filters
            $query = Task::query();

            if ($status) {
                $query->where('status', $status);
            }

            $tasks = $query->where('user_id', Auth::id())->cursorPaginate(10);

            return view('client.tasks.index', compact('tasks', 'status', 'title'));
        } catch (Exception $e) {
            Log::error('Failed to retrieve tasks: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to retrieve tasks.');
        }
    }

    public function create()
    {
        $title = "Create Task";

        return view('client.tasks.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in-progress,completed',
        ]);

        try {
            Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'user_id' => Auth::id(),
            ]);

            return redirect()->route('client.tasks.index')->with('success', 'Task created successfully!');
        } catch (Exception $e) {
            Log::error('Failed to create task: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create task. Please try again.');
        }
    }

    public function edit(Task $task)
    {
        $title = "Edit Task";

        return view('client.tasks.edit', compact('task', 'title'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in-progress,completed',
        ]);

        try {
            $task->update($request->all());

            return redirect()->route('client.tasks.index')->with('success', 'Task updated successfully!');
        } catch (Exception $e) {
            Log::error('Failed to update task: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update task. Please try again.');
        }
    }

    public function destroy(Task $task)
    {
        try {
            $task->delete();

            return redirect()->route('client.tasks.index')->with('success', 'Task deleted successfully!');
        } catch (Exception $e) {
            Log::error('Failed to delete task: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete task. Please try again.');
        }
    }
}
