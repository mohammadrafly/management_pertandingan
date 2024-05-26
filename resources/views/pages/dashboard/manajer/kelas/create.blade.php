@extends('layouts.app')

@section('content')

<form action="{{ route('manajer.kelas.create', $id_kelas) }}" method="POST">
    @csrf

    <div class="mb-4">
        <label for="atlet_id" class="block text-gray-700">Atlet</label>
        <select name="atlet_id" id="atlet_id" class="js-example-basic-single w-full px-3 py-2 border rounded @error('atlet_id') border-red-500 @enderror">
            <option value="">Pilih Atlet</option>
            @foreach ($atlet as $item)
                <option value="{{ $item->id }}" {{ old('atlet_id') == $item->id ? 'selected' : '' }}>{{ $item->atlet->nama }}</option>
            @endforeach
        </select>
        @error('atlet_id')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="kelas_id" class="block text-gray-700">Kelas</label>
        <select name="kelas_id" id="kelas_id" class="w-full px-3 py-2 border rounded @error('kelas_id') border-red-500 @enderror" disabled>
            <option value="{{ $kelas->id }}" selected>{{ $kelas->nama }}</option>
        </select>
    </div>

    <div class="mb-4">
        <button type="submit" class="bg-blue-500 text-white p-2 rounded-md shadow-md hover:bg-blue-600">Tambah</button>
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
