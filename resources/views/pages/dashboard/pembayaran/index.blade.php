@extends('layouts.app')

@section('content')

@php
    use Akaunting\Money\Money;
@endphp

<table id="table" class="w-full display responsive min-w-full">
    <thead>
        <tr>
            <th>#</th>
            <th>Pertandingan</th>
            <th>Tim</th>
            <th>Total</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->pertandingan->pertandingan }}</td>
            <td>{{ $item->team->nama }}</td>
            <td>{{ Money::IDR($item->total, true)  }}</td>
            <td>
                <span class="{{ $item->status === '1' ? 'bg-green-500' : 'bg-red-500'}} rounded py-1 px-3 text-white uppercase">
                    {{ $item->status === '1' ? 'Berhasil' : 'Gagal'}}
                </span>
            </td>
            <td>
                <div class="items-center justify-center flex-wrap space-x-1">
                    <a href="{{ route('pembayaran.delete', $item->id)}}" onclick="return confirm('Are you sure you want to delete this pembayaran?');" class="transition-colors duration-300 bg-red-500 p-1 rounded text-white mr-3 hover:bg-white border-red-500 border hover:text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </a>
                </div>
                
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@section('script')
        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
        <!-- DataTables Responsive CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    
        <!-- jQuery -->
        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- DataTables JS -->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
        <!-- DataTables Responsive JS -->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    
        <script>
            $(document).ready(function() {
                $('#table').DataTable({
                    responsive: true
                });
            });
        </script>
@endsection
