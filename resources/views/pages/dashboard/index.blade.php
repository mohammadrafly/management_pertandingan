@extends('layouts.app')

@section('content')

<div class="flex items-center justify-center">
    <div x-data="countdownTimer('{{ $countdown->dimulai }}')" class="p-8 text-center">
        <h1 class="text-4xl font-bold mb-4">Hitung Mundur Pertandingan</h1>
        <div class="text-6xl font-mono" x-text="timeRemaining"></div>
    </div>
</div>

<div class="flex justify-between items-center gap-10">
    <a href="{{ route('user')}}" class="flex justify-center items-center w-full">
        <div class="shadow-lg transition duration-300 hover:bg-sky-100 bg-sky-50 border-0.5 w-full h-fit rounded-2xl px-5 py-5 flex justify-between items-center">
            <div class="bg-blue-200 border p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-blue-500 w-12 h-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>  
            </div>
            <div class="block text-right semibold text-2xl"> 
                <h1>Total User</h1>
                <p>{{ $totalUser }}</p>
            </div>
        </div>
    </a>
    <a href="{{ route('atlet')}}" class="flex justify-center items-center w-full">
        <div class="shadow-lg transition duration-300 hover:bg-sky-100 bg-sky-50 border-0.5 w-full h-fit rounded-2xl px-5 py-5 flex justify-between items-center">
            <div class="bg-sky-200 border p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-sky-500 w-12 h-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                </svg>  
            </div>
            <div class="block text-right semibold text-2xl"> 
                <h1>Total Atlet</h1>
                <p>{{ $totalAtlet }}</p>
            </div>
        </div>
    </a>
    <a href="{{ route('tim')}}" class="flex justify-center items-center w-full">
        <div class="shadow-lg transition duration-300 hover:bg-sky-100 bg-sky-50 border-0.5 w-full h-fit rounded-2xl px-5 py-5 flex justify-between items-center">
            <div class="bg-green-200 border p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-green-500 w-12 h-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg> 
            </div>
            <div class="block text-right semibold text-2xl"> 
                <h1>Total Tim</h1>
                <p>{{ $totalTim }}</p>
            </div>
        </div>
    </a>
</div>

@endsection

@section('second-content')
    
<div class="grid grid-cols-3 gap-5">
    <div class="py-20 col-span-1">
        <div class="bg-white p-10 w-full">
            <canvas id="myDonat"></canvas> 
        </div>
    </div>

    <div class="py-20 col-span-2">
        <div class="bg-white p-10 w-full">
            <canvas id="myBar"></canvas> 
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
     const ctx = document.getElementById('myDonat');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_map(function($label) { return ucwords($label); }, array_keys($totalAtletPerKelas))) !!},
            datasets: [{
                label: '# of Atlet Per Kelas',
                data: {!! json_encode(array_values($totalAtletPerKelas)) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Total Atlet Per Kelas'
                }
            }
        },
    });

    const ctxBar = document.getElementById('myBar');

    const tournamentData = <?php echo json_encode($totalAtletInPertandingan); ?>;

    const tournamentNames = Object.keys(tournamentData);
    const totalAthletes = Object.values(tournamentData);

    console.log(tournamentNames)

    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: tournamentNames,
            datasets: [{
                label: '# of Atlet',
                data: totalAthletes,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Total Atlet in Pertandingan' // Adjust title as needed
                }
            }
        },
    });
    
    function countdownTimer(startTime) {
        return {
            timeRemaining: '',
            init() {
                const targetDate = new Date(startTime);
                this.updateTime();

                setInterval(() => {
                    this.updateTime(targetDate);
                }, 1000);
            },
            updateTime(targetDate) {
                const now = new Date();
                const difference = targetDate - now;

                if (difference <= 0) {
                    this.timeRemaining = 'Event has started!';
                    return;
                }

                const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                this.timeRemaining = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            }
        }
    }
</script>
@endsection