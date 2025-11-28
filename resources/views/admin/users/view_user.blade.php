@extends('layouts.admin') {{-- Make sure this extends your actual admin layout file --}}

@section('content')
    <div class="px-6 py-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Manage Users</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6">
            @if ($users->isEmpty())
                <div class="text-center py-10">
                    <h4 class="text-lg font-semibold mb-4 text-gray-700">No Users Found</h4>
                    <p class="text-gray-600">There are no registered users (excluding admins, if filtered).</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="table table-bordered table-striped">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone No.</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered On</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="py-3 px-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->id }}</td>
                                    <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-700">{{ $user->name }}</td>
                                    <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-700">{{ $user->email }}</td>
                                    <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-700">{{ $user->phone_no ?? 'N/A' }}</td>
                                    <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-700">{{ $user->address ?? 'N/A' }}</td>
                                    <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-700">{{ $user->created_at->format('M d, Y') }}</td>
                                    <td class="py-3 px-4 whitespace-nowrap text-sm font-medium">
                                        {{-- Only Delete Action --}}
                                        <div class="flex items-center space-x-2">
                                            {{-- Delete Form/Button --}}
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete {{ $user->name }} (ID: {{ $user->id }})? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }} {{-- Pagination links --}}
                </div>
            @endif
        </div>
    </div>
@endsection