@extends('layouts.user')

@section('title', 'My Profile')

@section('content')
    {{-- This div provides consistent padding (p-6) around the entire content block --}}
    <div class="p-6">
        {{-- This inner div handles the centering (mx-auto) and max-w-4xl) of your page content --}}
        <div class="max-w-4xl mx-auto mt-8">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">My Details</h1>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Display validation errors --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul class="mb-0 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- The main form card --}}
            <div class="bg-white shadow-md rounded-lg p-8">
                <form action="{{ route('user.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- MODIFIED: Changed to grid-cols-1 to make it a single column layout on all screen sizes --}}
                    {{-- Rearranged the order of fields as requested --}}
                    <div class="grid grid-cols-1 gap-6">
                        {{-- Name Field --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email Field (Now directly below Name) --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Phone Number Field (Now below Email) --}}
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('phone') border-red-500 @enderror"
                                placeholder="e.g., +975XXXXXXXX">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Address Field (Now directly below Phone Number) --}}
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                            <textarea id="address" name="address" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('address') border-red-500 @enderror">{{ old('address', $user->address ?? '') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <button type="submit"
                            class="bg-green-600 text-white px-5 py-2.5 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 font-medium text-lg">
                            Update Details
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection