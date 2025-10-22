@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
        </div>

        <div class="mb-3">
    <label for="phone">Phone</label>
    <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label for="role">Role</label>
    <input type="text" name="role" value="{{ old('role', $user->role ?? '') }}" class="form-control">
</div>


        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
