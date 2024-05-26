@extends('layouts.app')

@section('tambah')
    <a href="{{ route('manajer.atlet.create')}}" class="transition-colors duration-300 flex items-center bg-blue-500 text-white py-1.5 px-4 rounded hover:bg-white border-blue-500 border hover:text-blue-500">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Tambah
    </a>
@endsection

@section('content')

<table id="table" class="w-full display compact">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Berat Badan</th>
            <th>Foto Diri</th>
            <th>Foto KTP</th>
            <th>Ijazah Karate</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->atlet->nama }}</td>
            <td>{{ $item->atlet->jk == 'l' ? 'Laki-laki' : 'Perempuan' }}</td>
            <td>{{ $item->atlet->bb }}</td>
            <td>{{ $item->atlet->foto }}</td>
            <td>{{ $item->atlet->foto_ktp }}</td>
            <td>{{ $item->atlet->ijazah_karate }}</td>
            <td class="flex items-center">
                <a href="{{ route('manajer.atlet.update', $item->atlet->id)}}" class="transition-colors duration-300 bg-blue-500 p-1 rounded text-white mr-3 hover:bg-white border-blue-500 border hover:text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                </a>
                <a href="{{ route('manajer.atlet.delete', $item->atlet->id)}}" onclick="return confirm('Are you sure you want to delete this atlet?');" class="transition-colors duration-300 bg-red-500 p-1 rounded text-white mr-3 hover:bg-white border-red-500 border hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@section('script')
    <script>
        $(document).ready( function () {
            $('#table').DataTable();
        } );
    </script>
@endsection
