<?php

namespace App\Http\Controllers\Admin;

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
            $userId = $request->get('user_id');

            // Build query with optional filters
            $query = Task::query();

            if ($status) {
                $query->where('status', $status);
            }

            if ($userId) {
                $query->where('user_id', $userId);
            }

            // Admins can see all tasks, Users can only see their own
            $tasks = $query->cursorPaginate(10);

            $users = User::all();

            return view('admin.tasks.index', compact('tasks', 'title', 'status', 'userId', 'users'));
        } catch (Exception $e) {
            Log::error('Failed to retrieve tasks: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to retrieve tasks.');
        }
    }

    public function create()
    {
        $title = "Create Task";

        return view('admin.tasks.create', compact('title'));
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

            return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully!');
        } catch (Exception $e) {
            Log::error('Failed to create task: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create task. Please try again.');
        }
    }

    public function edit(Task $task)
    {
        $title = "Edit Task";

        return view('admin.tasks.edit', compact('task', 'title'));
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

            return redirect()->route('admin.tasks.index')->with('success', 'Task updated successfully!');
        } catch (Exception $e) {
            Log::error('Failed to update task: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update task. Please try again.');
        }
    }

    public function destroy(Task $task)
    {
        try {
            $task->delete();

            return redirect()->route('admin.tasks.index')->with('success', 'Task deleted successfully!');
        } catch (Exception $e) {
            Log::error('Failed to delete task: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete task. Please try again.');
        }
    }
}
