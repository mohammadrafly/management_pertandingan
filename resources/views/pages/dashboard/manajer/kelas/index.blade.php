@extends('layouts.app')

@section('content')

<div class="grid grid-cols-3 gap-5">
    @foreach ($data as $item)
    <a href="{{ route('manajer.kelas.list', $item->id)}}" class="text-white bg-[#cb1a29] rounded-xl">
        <img src="{{ asset('storage/thumbnail_kelas/'. $item->img )}}" alt="" class="rounded-t-xl w-[600px] h-[300px] object-cover">
        <div class="p-2">
            <h1 class="font-semibold">{{ $item->nama }}</h1>
            <p class="font-thin">{{ ucwords(str_replace('_', ' ', $item->kategori)) }} - {{ $item->gender == 'l' ? 'Laki-laki' : 'Perempuan'}}</p>
        </div>
    </a>
    @endforeach
</div>

@endsection
