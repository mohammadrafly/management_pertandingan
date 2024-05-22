@extends('layouts.auth')

@section('content')
    
<div class="bg-white shadow-md p-5 max-w-md mx-10 min-w-[400px] min-h-fit py-10 px-10 rounded-lg flex justify-center items-center">
    <div>
        <div class="text-2xl font-bold mb-4 text-center uppercase">{{ env('APP_NAME') }}</div>
        <div class="text-base font-thin mb-4 text-center">Silahkan login dengan akun anda.</div>
        <div class="py-2">
            @include('components.flash')
        </div>
        <div>
            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" placeholder="Masukkan Email" id="email" value="{{ old('email') }}" class="mt-1 p-2 border border-gray-300 rounded-md w-full">
                    @error('email')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" placeholder="Masukkan Password" id="password" class="mt-1 p-2 border border-gray-300 rounded-md w-full">
                    @error('password')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded w-full">Login</button>
            </form>
            <div class="py-2 font-semibold text-gray-500">Don't have an account? <a href="{{ route('register') }}" class="text-sky-500">register</a></div>
        </div>
    </div>
</div>

@endsection
