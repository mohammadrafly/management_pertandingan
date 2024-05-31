@extends('layouts.app')

@section('tambah')
    <a href="{{ route('kelas.create')}}" class="transition-colors duration-300 flex items-center bg-blue-500 text-white py-1.5 px-4 rounded hover:bg-white border-blue-500 border hover:text-blue-500">
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
            <th>Nama Atlet</th>
            <th>Tim</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->listAtletInTeam->atlet->nama}}</td>
            <td>{{ $item->listAtletInTeam->team->nama }}</td>
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
