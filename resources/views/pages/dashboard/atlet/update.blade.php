@extends('layouts.app')

@section('content')

<form action="{{ route('atlet.update', $data->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-4">
        <label for="nama" class="block text-gray-700">Nama</label>
        <input type="text" name="nama" id="nama" class="w-full px-3 py-2 border rounded @error('nama') border-red-500 @enderror" value="{{ old('nama') ?? $data->nama }}">
        @error('nama')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4 flex gap-5">
        <div class="w-full">
            <label for="tempat" class="block text-gray-700">Tempat Lahir</label>
            @php
                $tempat = explode(',', old('tempat') ?? $data->ttl)[0];
            @endphp
            <input type="text" name="tempat" id="tempat" class="w-full px-3 py-2 border rounded @error('tempat') border-red-500 @enderror" value="{{ $tempat }}">
            @error('tempat')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="w-full">
            <label for="tanggal" class="block text-gray-700">Tanggal Lahir</label>
            @php
                $tanggal = date('Y-m-d', strtotime(explode(',', old('tanggal') ?? $data->ttl)[1]));
            @endphp
            <input type="date" name="tanggal" id="tanggal" class="w-full px-3 py-2 border rounded @error('tanggal') border-red-500 @enderror" value="{{ $tanggal }}">
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
                <option value="l" {{ old('jk') == 'l' ? 'selected' : ($data->jk == 'l' ? 'selected' : '') }}>Laki-laki</option>
                <option value="p" {{ old('jk') == 'p' ? 'selected' : ($data->jk == 'p' ? 'selected' : '') }}>Perempuan</option>
            </select>
            @error('jk')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="w-full">
            <label for="bb" class="block text-gray-700">Berat Badan</label>
            <input type="number" name="bb" id="bb" class="w-full px-3 py-2 border rounded @error('bb') border-red-500 @enderror" value="{{ old('bb') ?? $data->bb }}">
            @error('bb')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="mb-4 flex gap-5">
        <div class="w-full">
            <label for="foto" class="block text-gray-700">Foto</label>
            <input type="file" name="foto" id="foto" class="w-full px-3 py-2 border rounded @error('foto') border-red-500 @enderror">
            @if ($data && $data->foto)
                <div class="mt-2">
                    <img src="{{ asset('storage/fotos/' . $data->foto) }}" alt="Current Foto" class="max-w-xs">
                </div>
            @endif
            @error('foto')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="w-full">
            <label for="foto_ktp" class="block text-gray-700">Foto KTP</label>
            <input type="file" name="foto_ktp" id="foto_ktp" class="w-full px-3 py-2 border rounded @error('foto_ktp') border-red-500 @enderror">
            @if ($data && $data->foto_ktp)
                <div class="mt-2">
                    <img src="{{ asset('storage/foto_ktp/' . $data->foto_ktp) }}" alt="Current Foto KTP" class="max-w-xs">
                </div>
            @endif
            @error('foto_ktp')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="mb-4">
        <label for="ijazah_karate" class="block text-gray-700">Ijazah Karate</label>
        <input type="file" name="ijazah_karate" id="ijazah_karate" class="w-full px-3 py-2 border rounded @error('ijazah_karate') border-red-500 @enderror">
        @if ($data && $data->ijazah_karate)
            <div class="mt-2 w-fit h-fit">
                <iframe src="{{ asset('storage/ijazah_karate/' . $data->ijazah_karate) }}" width="100%" height="500px"></iframe>
            </div>
        @endif
        @error('ijazah_karate')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <button type="submit" class="bg-blue-500 text-white p-2 rounded-md shadow-md hover:bg-blue-600">Update</button>
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
