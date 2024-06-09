@extends('layouts.app')

@section('content')
@php
    use Akaunting\Money\Money;
@endphp
<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
    <div class="bg-sky-100 p-5 rounded shadow-lg items-center flex justify-between flex-col lg:flex-row">
        <div>
            {{ $pertandingan->pertandingan }}
        </div>
        <div class="mt-3 lg:mt-0">
            @if ($joined_pertandingan == null)
                @if ($pembayaran_saat_ini != null && $pembayaran_saat_ini->status == '0')
                    <a href="#" class="uppercase bg-gray-500 hover:bg-gray-600 cursor-not-allowed text-white py-2 px-3 rounded font-semibold">Daftar</a>
                @else
                    @if ($atlet->isEmpty())
                        <a href="#" class="uppercase bg-gray-500 hover:bg-gray-600 cursor-not-allowed text-white py-2 px-3 rounded font-semibold" title="Tambahkan atlet terlebih dahulu">Daftar</a>
                    @else
                        <a href="{{ route('manajer.pertandingan.daftar', ['pertandingan' => $pertandingan->id, 'team' => $team_id])}}" class="daftar-button uppercase bg-blue-500 hover:bg-blue-600 text-white py-2 px-3 rounded font-semibold">Daftar</a>
                    @endif
                @endif
            @else
                <div x-data="countdownTimer('{{ $countdown->dimulai ?? '' }}')" x-init="init()" class="text-center">
                    <div class="text-xl font-mono" x-text="timeRemaining"></div>
                </div>
            @endif
        </div>
    </div>
    <div class="bg-sky-100 p-5 rounded shadow-lg flex justify-between items-center flex-col lg:flex-row">
        <div>
            @if ($pembayaran_saat_ini && $pembayaran_saat_ini->status == '0')
                Tagihan {{ Money::IDR($pembayaran_saat_ini->total, true) }}
            @elseif ($atlet->isEmpty())
                Tambahkan atlet ke dalam kelas terlebih dahulu
            @elseif (!$pembayaran_saat_ini)
                Silahkan daftar pertandingan
            @elseif ($pembayaran_saat_ini && $pembayaran_saat_ini->status == '1')
                Tidak ada tagihan! siapkan atlet anda untuk berkompetisi!
            @endif
        </div>
        <div class="mt-3 lg:mt-0">
            @if ($pembayaran_saat_ini && $pembayaran_saat_ini->status == '0')
                <button id="payButton" class="uppercase bg-blue-500 hover:bg-blue-600 text-white py-2 px-3 rounded font-semibold">Bayar</button>
            @endif
        </div>
    </div>
</div>

<div class="py-10">
    <div>
        <h1 class="mb-5 text-lg font-semibold">History Pembayaran</h1>

        <table class="w-full shadow-md display responsive min-w-full">
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
                    <td class="py-2 px-2">{{ $item->pertandingan->pertandingan }}</td>
                    <td class="py-2 px-2">{{ Money::IDR($item->total, true) }}</td>
                    <td class="py-2 px-2">
                        <span class="{{ $item->status === '1' ? 'bg-green-500' : 'bg-red-500' }} rounded py-1 px-3 text-white uppercase">
                            {{ $item->status === '1' ? 'Berhasil' : 'Gagal' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex justify-center items-center my-4">
            <a href="{{ route('manajer.pembayaran', $team_id) }}" class="text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-md shadow-md transition duration-300">
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

        // Confirmation popup for registration
        $('.daftar-button').click(function(event) {
            event.preventDefault();
            var url = $(this).attr('href');
            if (confirm('Apakah Anda yakin ingin mendaftar untuk pertandingan ini?')) {
                window.location.href = url;
            }
        });
    });

    function countdownTimer(startTime) {
        return {
            timeRemaining: '',
            init() {
                const targetDate = new Date(startTime);
                this.updateTime(targetDate);

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
