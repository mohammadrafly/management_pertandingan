@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Update Profile</h1>
    <form action="{{ route('profile') }}" method="POST" class="mb-8">
        @csrf
        @method('POST')
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
            <input type="text" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('name', $data->name) }}" required>
            @error('name')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('email', $data->email) }}" required>
            @error('email')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Profile</button>
    </form>

    <hr class="mb-8">

    <h1 class="text-2xl font-bold mb-4">Update Password</h1>

    <form action="{{ route('password') }}" method="POST">
        @csrf
        @method('POST')

        <div class="mb-4">
            <label for="old_password" class="block text-gray-700 text-sm font-bold mb-2">Old Password</label>
            <input type="password" name="old_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            @error('old_password')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="new_password" class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
            <input type="password" name="new_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            @error('new_password')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="new_password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm New Password</label>
            <input type="password" name="new_password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            @error('new_password_confirmation')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Password</button>
    </form>
</div>
@endsection
