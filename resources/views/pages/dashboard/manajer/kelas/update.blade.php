@extends('layouts.app')

@section('content')

<form action="{{ route('manajer.kelas.update', $data->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-4">
        <label class="block text-gray-700">Atlet</label>
        <select class="w-full px-3 py-2 border rounded" disabled>
            <option value="{{$data->atlet_id }}" selected>{{ $data->atlet->nama}}</option>
        </select>
    </div>

    <div class="mb-4">
        <label for="kelas_id" class="block text-gray-700">Kelas</label>
        <select name="kelas_id" id="kelas_id" class="js-example-basic-single w-full px-3 py-2 border rounded @error('kelas_id') border-red-500 @enderror">
            <option value="">Pilih Kelas</option>
            @foreach ($kelas as $item)
                <option value="{{ $item->id }}" {{ old('kelas_id') == $item->id || (isset($data) && $data->kelas_id == $item->id) ? 'selected' : '' }}>{{ $item->nama }}</option>
            @endforeach
        </select>
        @error('kelas_id')
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
