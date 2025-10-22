@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-3">Users</h2>

    <!-- Filter form -->
    <form class="d-flex mb-3" method="GET" action="{{ route('users.index') }}">
        <input type="text" name="filter" class="form-control me-2" placeholder="Search name/email" value="{{ $filter }}">
        <button class="btn btn-primary">Filter</button>
    </form>

    <!-- Add new user button -->
    <a href="{{ route('users.create') }}" class="btn btn-success mb-3">Add New User</a>

    <!-- Users table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th> <!-- Display phone -->
                <th>Role</th>  <!-- Display role -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone ?? '-' }}</td>
                <td>{{ $user->role ?? '-' }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No users found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
