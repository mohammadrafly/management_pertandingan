@extends('layouts.app')

@section('content')

<form action="{{ route('manajer.atlet.create') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <label for="nama" class="block text-gray-700">Nama</label>
        <input type="text" name="nama" id="nama" class="w-full px-3 py-2 border rounded @error('nama') border-red-500 @enderror" value="{{ old('nama') }}">
        @error('nama')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4 flex gap-5">
        <div class="w-full">
            <label for="tempat" class="block text-gray-700">Tempat Lahir</label>
            <input type="text" name="tempat" id="tempat" class="w-full px-3 py-2 border rounded @error('tempat') border-red-500 @enderror" value="{{ old('tempat') }}">
            @error('tempat')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="w-full">
            <label for="tanggal" class="block text-gray-700">Tanggal Lahir</label>
            <input type="date" name="tanggal" id="tanggal" class="w-full px-3 py-2 border rounded @error('tanggal') border-red-500 @enderror" value="{{ old('tanggal') }}">
            @error('tanggal')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="mb-4 flex gap-5">
        <div class="w-full">
            <label for="jk" class="block text-gray-700">Jenis Kelamin</label>
            <select name="jk" id="jk" class="w-full px-3 py-2 border rounded @error('jk') border-red-500 @enderror">
                <option value="">Pilih Jenis Kelamin</option>
                <option value="l" {{ old('jk') == 'l' ? 'selected' : '' }}>Laki-laki</option>
                <option value="p" {{ old('jk') == 'p' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jk')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="w-full">
            <label for="bb" class="block text-gray-700">Berat Badan</label>
            <input type="number" name="bb" id="bb" class="w-full px-3 py-2 border rounded @error('bb') border-red-500 @enderror" value="{{ old('bb') }}">
            @error('bb')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="mb-4">
        <label for="foto" class="block text-gray-700">Foto</label>
        <input type="file" name="foto" id="foto" class="w-full px-3 py-2 border rounded @error('foto') border-red-500 @enderror">
        @error('foto')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="foto_ktp" class="block text-gray-700">Foto KTP</label>
        <input type="file" name="foto_ktp" id="foto_ktp" class="w-full px-3 py-2 border rounded @error('foto_ktp') border-red-500 @enderror">
        @error('foto_ktp')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="ijazah_karate" class="block text-gray-700">Ijazah Karate</label>
        <input type="file" name="ijazah_karate" id="ijazah_karate" class="w-full px-3 py-2 border rounded @error('ijazah_karate') border-red-500 @enderror">
        @error('ijazah_karate')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <button type="submit" class="bg-blue-500 text-white p-2 rounded-md shadow-md hover:bg-blue-600">Submit</button>
    </div>
</form>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection
