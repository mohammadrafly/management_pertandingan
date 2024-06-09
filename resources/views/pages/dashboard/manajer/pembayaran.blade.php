@extends('layouts.app')

@section('content')

@php
    use Akaunting\Money\Money;
@endphp

<div class="overflow-x-auto">
    <table class="w-full display responsive min-w-ful">
        <thead class="bg-sky-500">
            <tr class="text-white text-left">
                <th class="py-2 px-4">Tanggal</th>
                <th class="py-2 px-4">Pertandingan</th>
                <th class="py-2 px-4">Total Tagihan</th>
                <th class="py-2 px-4">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr class="transition duration-300 hover:bg-gray-200">
                <td class="py-2 px-4 whitespace-nowrap">{{ $item->created_at }}</td>
                <td class="py-2 px-4 whitespace-nowrap">{{ $item->pertandingan->pertandingan }}</td>
                <td class="py-2 px-4 whitespace-nowrap">{{ Money::IDR($item->total, true) }}</td>
                <td class="py-2 px-4 whitespace-nowrap">
                    <span class="{{ $item->status === '1' ? 'bg-green-500' : 'bg-red-500' }} rounded py-1 px-3 text-white uppercase">
                        {{ $item->status === '1' ? 'Berhasil' : 'Gagal' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
