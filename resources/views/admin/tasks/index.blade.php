@extends('admin.partials.main')

@section('content')
<div class="tasks-container mt-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center">
        <h2>Tasks</h2>
        <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">Create Task</a>
    </div>

    <form method="GET" action="{{ route('admin.tasks.index') }}" class="mb-4">
        <div class="form-row">
            <div class="col">
                <select name="status" class="form-control">
                    <option value="">Filter by Status</option>
                    <option {{ $status == 'pending' ? 'selected' : '' }} value="pending">Pending</option>
                    <option {{ $status == 'completed' ? 'selected' : '' }} value="completed">Completed</option>
                </select>
            </div>
            @if(Auth::user()->hasRole('Admin'))
                <div class="col">
                    <select name="user_id" class="form-control">
                        <option value="">Filter by User</option>
                        @foreach($users as $user)
                            <option {{ $userId == $user->id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="col">
                <button type="submit" class="btn btn-secondary">Filter</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>User</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ ucfirst($task->status) }}</td>
                    <td>{{ $task->user->name }}</td>
                    <td>
                        <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $tasks->links() }}
    </div>
</div>
@endsection
