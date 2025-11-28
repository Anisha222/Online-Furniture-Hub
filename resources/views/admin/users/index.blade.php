@extends('layouts.admin') {{-- Assuming your admin layout file is layouts/admin.blade.php --}}

@section('title', 'Manage Users')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 fw-bold text-dark">Manage Registered Users</h1>

    @if(session('success'))
        <div class="alert alert-success mb-4 shadow-sm" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            @if ($users->isEmpty())
                <div class="alert alert-info text-center" role="alert">
                    No users have registered yet.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Address</th>
                                <th scope="col">Registered On</th>
                                {{-- <th scope="col">Actions</th> Uncomment if you add edit/delete functionality --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? 'N/A' }}</td> {{-- Display phone, 'N/A' if null --}}
                                    <td>{{ $user->address ?? 'N/A' }}</td> {{-- Display address, 'N/A' if null --}}
                                    <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                                    {{-- <td>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary me-2">Edit</a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                        </form>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection