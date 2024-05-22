@extends('layouts.app')

@section('content')
    
<form method="POST" action="{{ route('pertandingan.update', $data->id) }}">
    @csrf

    <div class="mb-4">
        <label for="pertandingan" class="block text-gray-700">Nama Pertandingan</label>
        <input type="text" name="pertandingan" id="pertandingan" value="{{ old('pertandingan', $data->pertandingan) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('pertandingan') border-red-500 @enderror">
        @error('pertandingan')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="dimulai" class="block text-gray-700">Dimulai</label>
        <input type="date" pertandingan="dimulai" id="dimulai" value="{{ old('dimulai', $data->dimulai) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('dimulai') border-red-500 @enderror">
        @error('dimulai')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="mb-4">
        <label for="diakhiri" class="block text-gray-700">Diakhiri</label>
        <input type="date" pertandingan="diakhiri" id="diakhiri" value="{{ old('diakhiri', $data->diakhiri) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('diakhiri') border-red-500 @enderror">
        @error('diakhiri')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Submit</button>
    </div>
</form>

@endsection