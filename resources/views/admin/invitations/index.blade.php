@extends('admin.partials.main')

@section('admin-content')
    <div class="invitations-container mt-4">
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
            <h2>Your Invitations</h2>
            <a href="{{ route('admin.invitations.create') }}" class="btn btn-primary">Create Invitation</a>
        </div>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Token</th>
                    <th>Expires At</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invitations as $invitation)
                    <tr>
                        <td>{{ $invitation->email }}</td>
                        <td>{{ $invitation->token }}</td>
                        <td>{{ date('d/m/Y', strtotime($invitation->expires_at)) }}</td>
                        <td>
                            @if ($invitation->isExpired())
                                <span class="text-danger">Expired</span>
                            @else
                                <span class="text-success">Active</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.invitations.resend', $invitation->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">Resend</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $invitations->links() }}
        </div>
    </div>
@endsection
