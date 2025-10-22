@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h2>Add New User</h2>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
   <div class="mb-3">
    <label for="phone">Phone</label>
    <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label for="role">Role</label>
    <input type="text" name="role" value="{{ old('role', $user->role ?? '') }}" class="form-control">
</div>

        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
