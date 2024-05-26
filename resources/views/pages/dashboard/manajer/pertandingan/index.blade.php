@extends('layouts.app')

@section('content')
@php
    use Akaunting\Money\Money;
@endphp
<div class="grid grid-cols-2 gap-10">
    <div class="bg-sky-100 p-5 rounded shadow-lg items-center flex justify-between">
        <div>
            {{ $pertandingan->pertandingan }}
        </div>
        <div>
            @if ($joined_pertandingan == null)
                @if ($pembayaran_saat_ini != null && $pembayaran_saat_ini->status == '0')
                <a href="#" class="uppercase bg-gray-500 hover:bg-gray-600 cursor-not-allowed text-white py-2 px-3 rounded font-semibold">Daftar</a>
                @else
                <a href="{{ route('manajer.pertandingan.daftar', ['pertandingan' => $pertandingan->id, 'team' => $team_id])}}" class="uppercase bg-blue-500 hover:bg-blue-600 text-white py-2 px-3 rounded font-semibold">Daftar</a>
                @endif
            @else
                <div x-data="countdownTimer('{{ $countdown->dimulai ?? '' }}')" x-init="init()" class="text-center">
                    <div class="text-xl font-mono" x-text="timeRemaining"></div>
                </div>
            @endif
        </div>
    </div>
    <div class="bg-sky-100 p-5 rounded shadow-lg flex justify-between items-center">
        <div>
            @if ($pembayaran_saat_ini && $pembayaran_saat_ini->status == '0')
                Tagihan {{ Money::IDR($pembayaran_saat_ini->total, true) }}
            @elseif (!$pembayaran_saat_ini)
                Silahkan daftar pertandingan terlebih dahulu.
            @elseif ($pembayaran_saat_ini && $pembayaran_saat_ini->status == '1')
                Tidak ada tagihan! siapkan atlet anda untuk berkompetisi!
            @endif
        </div>
        <div>
            @if ($pembayaran_saat_ini && $pembayaran_saat_ini->status == '0')
                <button id="payButton" class="uppercase bg-blue-500 hover:bg-blue-600 text-white py-2 px-3 rounded font-semibold">Bayar</button>
            @elseif (!$pembayaran_saat_ini)

            @endif
        </div>
    </div>
</div>

<div class="py-10">
    <div>
        <h1 class="mb-5">History Pembayaran</h1>

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

                @foreach ($pembayaran as $item)
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
        <div class="flex justify-center items-center my-4">
            <a href="#" class="text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-md shadow-md transition duration-300">
                Lihat Semua
            </a>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
     $(document).ready(function() {
        $('#payButton').click(function() {
            handlePayment();
        });

        function handlePayment() {
            $.ajax({
                url: '{{ route('manajer.pertandingan.bayar', ['pertandingan' => $pertandingan->id, 'team' => $team_id])}}',
                method: 'GET',
                success: function(response) {
                    window.snap.pay(response, {
                        onSuccess: function(result){
                            console.log('test');
                            updatePaymentStatus(result);
                        },
                        onPending: function(result){
                            alert("Payment pending!"); console.log(result);
                        },
                        onError: function(result){
                            alert("Payment failed!"); console.log(result);
                        },
                        onClose: function(){
                            alert('Payment pop-up closed without finishing the payment');
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function updatePaymentStatus(result) {
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            $.ajax({
                url: '{{ route('api.callback.success', $pembayaran_saat_ini->kode_pembayaran ?? '')}}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });

    function countdownTimer(startTime) {
        return {
            timeRemaining: '',
            init() {
                const targetDate = new Date(startTime);
                this.updateTime(targetDate);

                console.log(startTime)
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
        };
    }
</script>
@endsection
