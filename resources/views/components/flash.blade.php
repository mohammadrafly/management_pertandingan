@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-transition:enter="transition-opacity ease-out duration-300" x-transition:leave="transition-opacity ease-in duration-300" x-on:click.away="show = false" class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative w-full" role="alert">
    <strong class="font-bold">Success!</strong>
    <span class="block sm:inline">{{ session('success') }}</span>
    <button @click="show = false" class="absolute top-0 right-0 px-4 py-3 focus:outline-none">&times;</button>
</div>
@endif

@if(session('error'))
<div x-data="{ show: true }" x-show="show" x-transition:enter="transition-opacity ease-out duration-300" x-transition:leave="transition-opacity ease-in duration-300" x-on:click.away="show = false" class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative w-full" role="alert">
    <strong class="font-bold">Error!</strong>
    <span class="block sm:inline">{{ session('error') }}</span>
    <button @click="show = false" class="absolute top-0 right-0 px-4 py-3 focus:outline-none">&times;</button>
</div>
@endif

@if ($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
    <strong class="font-bold">Whoops!</strong>
    <span class="block sm:inline">There were some problems with your input.</span>
    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif