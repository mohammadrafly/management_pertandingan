@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('user.update', $data->id) }}">
  @csrf

  <div class="mb-4">
    <label for="name" class="block text-gray-700">Name</label>
    <input type="text" name="name" id="name" value="{{ old('name', $data->name) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('name') border-red-500 @enderror">
    @error('name')
      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div class="mb-4">
    <label for="email" class="block text-gray-700">Email</label>
    <input type="email" name="email" id="email" value="{{ old('email', $data->email) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('email') border-red-500 @enderror">
    @error('email')
      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div class="mb-4">
    <label for="role" class="block text-gray-700">Role</label>
    <select name="role" id="role" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('role') border-red-500 @enderror">
      <option value="">Pilih Role</option>
      <option value="admin" {{ $data->role == 'admin' ? 'selected' : '' }}>Admin</option>
      <option value="manager" {{ $data->role == 'manager' ? 'selected' : '' }}>Manager</option>
    </select>
    @error('role')
      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div class="flex justify-between">
    <p class="text-gray-600 text-sm mt-2">Are you sure you want to update this user?</p>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Confirm Update</button>
  </div>
</form>

@endsection
