@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Update Profile</h1>
    <form action="{{ route('profile') }}" method="POST" class="mb-8" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="mb-4">
            <label for="photo" class="block text-gray-700 text-sm font-bold mb-2 cursor-pointer">
                Photo
                <input type="file" name="photo" id="photo" accept="image/*" class="hidden">
            </label>
            <div class="bg-gray-300 size-64 rounded-lg cursor-pointer flex justify-center items-center relative" onclick="document.getElementById('photo').click()">
                @if ($data->photo)
                <img id="photoPreview" class="w-full h-full object-cover rounded-lg" src="{{ $data->photo ? asset('storage/foto_manager/'.$data->photo) : ''}}">
                @else
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="absolute size-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                @endif
            </div>
            <p class="text-gray-600 text-sm mt-2">Click to select a photo...</p>
        </div>

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
            <input type="text" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('name', $data->name) }}" required>
            @error('name')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('email', $data->email) }}" required>
            @error('email')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Profile</button>
    </form>

    <hr class="mb-8">

    <h1 class="text-2xl font-bold mb-4">Update Password</h1>

    <form action="{{ route('password') }}" method="POST">
        @csrf
        @method('POST')

        <div class="mb-4">
            <label for="old_password" class="block text-gray-700 text-sm font-bold mb-2">Old Password</label>
            <input type="password" name="old_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            @error('old_password')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="new_password" class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
            <input type="password" name="new_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            @error('new_password')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="new_password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm New Password</label>
            <input type="password" name="new_password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            @error('new_password_confirmation')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Password</button>
    </form>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>

<script>
document.getElementById('photo').addEventListener('change', function(event) {
    var photoPreview = document.getElementById('photoPreview');
    var idCardPhoto = document.getElementById('idCardPhoto');
    var file = event.target.files[0];
    var reader = new FileReader();

    reader.onload = function(e) {
        photoPreview.src = e.target.result;
        idCardPhoto.src = e.target.result;
    }

    reader.readAsDataURL(file);
});

document.getElementById('print-id-card-btn').addEventListener('click', function(event) {
    event.preventDefault();
    html2canvas(document.querySelector("#id-card-content"), {
        onrendered: function(canvas) {
            const imgData = canvas.toDataURL('image/png');
            const downloadLink = document.createElement('a');
            downloadLink.href = imgData;
            downloadLink.download = 'ID_Card.png';
            downloadLink.click();
        }
    });
});
</script>
@endsection
