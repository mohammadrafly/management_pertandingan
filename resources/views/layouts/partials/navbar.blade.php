<div class="bg-white flex justify-between items-center w-full">
    <div class="max-w-[300px] justify-between items-center px-5 hidden lg:flex">
        <img src="{{ asset('images/logo.png')}}" alt="" class="size-12 mr-2">
        <div class="items-center font-bold text-xl text-[#3d3d5c]">
            <a href="{{ route('dashboard')}}">{{ env('APP_NAME')}}</a>
        </div>
    </div>
    <div class="p-5 flex justify-between items-center w-full">
        <div x-on:click="open = ! open" class="cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </div>
        <div x-data="{ open: false }">
            <button class="transition-colors duration-300 flex justify-between items-center gap-5 hover:bg-[#cb1a29] hover:text-white text-gray-500 rounded-lg py-2 px-5" x-on:click="open = ! open">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <div class="block text-left text-sm">
                    <p class="font-bold">{{ Auth::user()->name }}</p>
                    <p class="text-xs">{{ Auth::user()->email }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div class="absolute border bg-white rounded-lg py-2 px-5 mt-5 min-w-[200px] font-semibold text-gray-500"
                x-show="open"
                x-transition:enter="transition-transform transform ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-5"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition-transform transform ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-5">
                <a href="{{ route('profile')}}" class="flex py-5 hover:text-[#3d3d5c] transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Edit Profile
                </a>
                <a href="#"
                    @click.prevent="if(confirm('Are you sure you want to logout?')) { window.location='{{ route('logout')}}' }">
                    <div class="flex py-5 transition-colors duration-300 hover:text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                        </svg>
                        Logout
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
