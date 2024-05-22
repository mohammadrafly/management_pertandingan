@extends('layouts.app')

@section('content')

<form action="{{ route('kelas.create') }}" method="POST" enctype="multipart/form-data" x-data="{
        kategori: '{{ old('kategori', '') }}',
        isBeregu() {
            return this.kategori.includes('beregu');
        },
        isKata() {
            return this.kategori.includes('kata');
        },
        bbMin: '{{ old('bb_min', ) }}',
        bbMax: '{{ old('bb_max', ) }}',
        updateBb() {
            if (!this.isBeregu() && !this.isKata()) {
                this.bb = this.bbMin + ' - ' + this.bbMax;
            } else {
                this.bb = '';
            }
        },
        bb: ''
    }" @submit.prevent="updateBb; $el.submit()">
    @csrf
    <div class="mb-4">
        <label for="nama" class="block text-gray-700">Nama</label>
        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="w-full px-3 py-2 border rounded @error('nama') border-red-500 @enderror">
        @error('nama')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="kategori" class="block text-gray-700">Tipe Kelas Harga</label>
        <select name="kategori" id="kategori" x-model="kategori" class="w-full px-3 py-2 border rounded @error('kategori') border-red-500 @enderror">
            <option value="">Pilih Kategori</option>
            <option value="kata_perorangan" {{ old('kategori') == 'kata_perorangan' ? 'selected' : ''}}>Kata Perorangan</option>
            <option value="kata_beregu" {{ old('kategori') == 'kata_beregu' ? 'selected' : ''}}>Kata Beregu</option>
            <option value="kumite_perorangan" {{ old('kategori') == 'kumite_perorangan' ? 'selected' : ''}}>Kumite Perorangan</option>
            <option value="kumite_beregu" {{ old('kategori') == 'kumite_beregu' ? 'selected' : ''}}>Kumite Beregu</option>
        </select>
        @error('kategori')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div id="bb_input" x-show="!isBeregu() && !isKata()">
        <div class="mb-4">
            <label for="bb_min" class="block text-gray-700">Berat Badan Min</label>
            <input type="number" name="bb_min" id="bb_min" min="45" max="100" x-model="bbMin" @input="updateBb" value="{{ old('bb_min', 45) }}" class="w-full px-3 py-2 border rounded @error('bb_min') border-red-500 @enderror" :disabled="isBeregu()">
            @error('bb_min')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="bb_max" class="block text-gray-700">Berat Badan Max</label>
            <input type="number" name="bb_max" id="bb_max" min="45" max="100" x-model="bbMax" @input="updateBb" value="{{ old('bb_max', 100) }}" class="w-full px-3 py-2 border rounded @error('bb_max') border-red-500 @enderror" :disabled="isBeregu()">
            @error('bb_max')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <input type="hidden" name="bb" x-model="bb">

    <div class="mb-4">
        <label for="img" class="block text-gray-700">Image</label>
        <input type="file" name="img" id="img" class="w-full px-3 py-2 border rounded @error('img') border-red-500 @enderror">
        @error('img')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="flex justify-end">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
    </div>
</form>

@endsection
