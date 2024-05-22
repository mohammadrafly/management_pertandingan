@extends('layouts.app')

@section('content')
    
<form action="{{ route('tim.create') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <label for="nama" class="block text-gray-700">Nama</label>
        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="w-full px-3 py-2 border rounded @error('nama') border-red-500 @enderror">
        @error('nama')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label for="email" class="block text-gray-700">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-3 py-2 border rounded @error('email') border-red-500 @enderror">
        @error('email')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label for="asal_institusi" class="block text-gray-700">Asal Institusi</label>
        <input type="text" name="asal_institusi" id="asal_institusi" value="{{ old('asal_institusi') }}" class="w-full px-3 py-2 border rounded @error('asal_institusi') border-red-500 @enderror">
        @error('asal_institusi')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label for="alamat" class="block text-gray-700">Alamat</label>
        <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}" class="w-full px-3 py-2 border rounded @error('alamat') border-red-500 @enderror">
        @error('alamat')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label for="manager" class="block text-gray-700">Manager</label>
        <select name="manager" id="manager" class="w-full px-3 py-2 border rounded @error('manager') border-red-500 @enderror">
            <option value="">Pilih Manager</option>
            @foreach ($manager as $m)
                <option value="{{ $m->id }}" {{ old('manager') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
            @endforeach
        </select>
        @error('manager')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label for="no_hp" class="block text-gray-700">No HP</label>
        <input type="number" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" class="w-full px-3 py-2 border rounded @error('no_hp') border-red-500 @enderror">
        @error('no_hp')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label for="foto" class="block text-gray-700">Foto</label>
        <input type="file" name="foto" id="foto" class="w-full px-3 py-2 border rounded @error('foto') border-red-500 @enderror">
        @error('foto')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label for="surat_tugas" class="block text-gray-700">Surat Tugas</label>
        <input type="file" name="surat_tugas" id="surat_tugas" class="w-full px-3 py-2 border rounded @error('surat_tugas') border-red-500 @enderror">
        @error('surat_tugas')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="flex justify-end">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
    </div>
</form>

@endsection