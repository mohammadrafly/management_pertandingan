@extends('layouts.app')

@section('content')

@php
    use Akaunting\Money\Money;
@endphp

<table class="w-full shadow-md">
    <thead class="text-left bg-sky-500">
        <tr class="text-white">
            <th class="py-2 px-2">Tanggal</th>
            <th class="py-2 px-2">Pertandingan</th>
            <th class="py-2 px-2">Total Tagihan</th>
            <th class="py-2 px-2">Status</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($data as $item)
        <tr class="transition duration-300 hover:bg-gray-200">
            <td class="py-2 px-2">{{ $item->created_at }}</td>
            <td class="py-2 px-2">{{ $item->pertandingan->pertandingan}}</td>
            <td class="py-2 px-2">{{ Money::IDR($item->total, true) }}</td>
            <td class="py-2 px-2">
                <span class="{{ $item->status === '1' ? 'bg-green-500' : 'bg-red-500'}} rounded py-1 px-3 text-white uppercase">
                    {{ $item->status === '1' ? 'Berhasil' : 'Gagal'}}
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
