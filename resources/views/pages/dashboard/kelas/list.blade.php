@extends('layouts.app')


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
