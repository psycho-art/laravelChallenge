@extends('admin.partials.main')

@section('content')
<div class="create-invitation-container mt-4">
    <h2>Create an Invitation</h2>

    <form method="POST" action="{{ route('admin.invitations.store') }}">
        @csrf
        <div class="form-group">
            <label for="email">Recipient Email</label>
            <input type="email" class="form-control" id="email" name="email" required>

            @error('email')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
