@extends('layouts.app')

@section('content')

<form action="{{ route('setting.update', $data->id) }}" method="POST">
    @csrf
    <div class="mb-4">
        <label for="type" class="block text-gray-700">Tipe Setting Harga</label>
        <select name="type" id="type" class="w-full px-3 py-2 border rounded @error('type') border-red-500 @enderror">
            <option value="">Pilih Type</option>
            <option value="pembayaran_tim" {{ old('type', $data->type) == 'pembayaran_tim' ? 'selected' : '' }}>Pembayaran Tim</option>
            <option value="pembayaran_atlet" {{ old('type', $data->type) == 'pembayaran_atlet' ? 'selected' : '' }}>Pembayaran Atlet</option>
        </select>
        @error('type')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="mb-4">
        <label for="harga" class="block text-gray-700">Harga</label>
        <input type="number" name="harga" id="harga" value="{{ old('harga', $data->harga) }}" class="w-full px-3 py-2 border rounded @error('harga') border-red-500 @enderror">
        @error('harga')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
    </div>
</form>

@endsection
