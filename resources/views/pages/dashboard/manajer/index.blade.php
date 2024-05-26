@extends('layouts.app')

@section('content')

<div class="px-5 text-gray-500">
    <div class="font-semibold text-xl">Data Tim</div>
</div>

<form action="{{ route('manajer.my.tim')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ $data ? $data->id : '' }}">
    <div class="block lg:grid lg:grid-cols-2 p-5 gap-10 text-gray-500">
        <div>
            <div class="py-2">
                <label for="nama">Nama Tim</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $data ? $data->nama : '') }}" placeholder="Masukkan Nama Tim" class="w-full px-3 py-2 border rounded outline-none">
            </div>
            <div class="py-2">
                <label for="asal_institusi">Asal Institusi</label>
                <input type="text" name="asal_institusi" id="asal_institusi" value="{{ old('asal_institusi', $data ? $data->asal_institusi : '') }}" placeholder="Masukkan Asal Institusi" class="w-full px-3 py-2 border rounded outline-none">
            </div>
            <div class="py-2">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" class="w-full px-3 py-2 border rounded outline-none">{{ old('alamat', $data ? $data->alamat : '') }}</textarea>
            </div>
            <div class="py-2">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $data ? $data->email : '') }}" placeholder="Masukkan Email" class="w-full px-3 py-2 border rounded outline-none">
            </div>
            <div class="font-semibold text-xl mb-5 mt-5">Data Manager</div>
            <div class="block lg:grid lg:grid-cols-2">
                <div class="py-2" disabled>
                    <label for="managerFoto">Foto Manager</label>
                    <div class="bg-gray-300 size-64 rounded-lg flex justify-center items-center relative cursor-not-allowed">
                        @if($data && $data->user->photo)
                            <img id="managerFotoPreview" class="w-full h-full object-cover rounded-lg" src="{{ asset('storage/foto_manager/'.$data->user->photo) }}" alt="Team Logo">
                        @else
                            <img id="managerFotoPreview" class="w-full h-full object-cover rounded-lg" src="#" alt="Team Logo" style="display: none;">
                            <svg id="managerFotoPlaceholder" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>
                        @endif
                    </div>
                </div>
                <div>
                    <div class="py-2">
                        <label for="name">Nama Manager</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $data ? $data->user->name : '') }}" placeholder="Masukkan Nama Tim" class="w-full px-3 py-2 border rounded outline-none bg-gray-200" disabled>
                    </div>
                    <div class="py-2">
                        <label for="no_hp">Nomor WhatsApp</label>
                        <input type="number" name="no_hp" id="no_hp" value="{{ old('no_hp', $data ? $data->no_hp : '') }}" placeholder="Masukkan Nomor WhatsApp" class="w-full px-3 py-2 border rounded outline-none">
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="py-2">
                <label for="teamLogo">Logo Tim</label>
                <div class="bg-gray-300 size-64 rounded-lg cursor-pointer flex justify-center items-center relative">
                    <input type="file" id="teamLogo" name="foto" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" onchange="previewImage(event, 'teamLogoPreview')">
                    @if($data && $data->foto)
                    <img id="teamLogoPreview" class="w-full h-full object-cover rounded-lg" src="{{ asset('storage/foto_tim/'.$data->foto) }}" alt="Team Logo">
                    @else
                    <img id="teamLogoPreview" class="w-full h-full object-cover rounded-lg" src="#" alt="Team Logo" style="display: none;">
                    <svg id="teamLogoPlaceholder" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>
                    @endif
                </div>
            </div>
            <div class="py-2">
                <label for="surat_tugas">Surat Tugas</label>
                <input type="file" name="surat_tugas" id="surat_tugas" class="w-full px-3 py-2 border rounded outline-none">
            </div>
            @if($data && $data->surat_tugas)
                <div class="py-2">
                    <label for="currentSuratTugas">Current Surat Tugas</label><br>
                    <a href="{{ asset('storage/surat_tugas/'.$data->surat_tugas) }}" download class="text-blue-500 hover:text-blue-600">{{ $data->surat_tugas }}</a>
                </div>
            @endif
        </div>
    </div>
    <div class="p-5">
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 ">Simpan</button>
    </div>
</form>

<script>
    function previewImage(event, previewId) {
        const input = event.target;
        const reader = new FileReader();
        const previewImg = document.getElementById(previewId);

        reader.onload = function() {
            if (reader.readyState === 2) {
                previewImg.src = reader.result;
                previewImg.style.display = 'block';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>

@endsection
