@extends('layouts.app')

@section('content')
    
<form method="POST" action="{{ route('user.create') }}">
    @csrf

    <div class="mb-4">
        <label for="name" class="block text-gray-700">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('name') border-red-500 @enderror">
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="email" class="block text-gray-700">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('email') border-red-500 @enderror">
        @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="role" class="block text-gray-700">Role</label>
        <select name="role" id="role" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('role') border-red-500 @enderror">
            <option value="">Pilih Role</option>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
        </select>
        @error('role')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="password" class="block text-gray-700">Password</label>
        <input type="password" name="password" id="password" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('password') border-red-500 @enderror">
        @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Submit</button>
    </div>
</form>

@endsection