@extends('layouts.app')

@section('content')

<div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
    @foreach ($data as $index => $item)
    <div>
        <div id="id-card-content-{{ $index }}" class="bg-white shadow-lg rounded-lg min-w-[200px] min-h-[400px]">
            <div class="bg-[#cb1a29] rounded-t-lg flex justify-center items-center py-32 p-10">
                <div>
                    <h1 class="text-5xl font-bold text-center text-white py-5">{{ $pertandingan->pertandingan }}</h1>
                    <div class="flex justify-center items-center py-2">
                        <img src="{{ asset('storage/fotos/'. $item->atlet->foto)}}" alt="Your Profile Picture" class="size-64 object-cover">
                    </div>
                    <div class="text-white text-center">
                        <h1 class="text-5xl font-bold">{{ $item->atlet->nama }}</h1>
                        <p class="text-3xl font-semibold">{{ $item->team->nama }}</p>
                        <p class="text-3xl font-semibold">Atlet</p>
                    </div>
                </div>
            </div>
            <div class="text-xl text-gray-700 bg-white p-10 rounded-b-lg">
                <h1 class="font-semibold">Kelas yang diikuti:</h1>
                @foreach ($item->listAtletWithKelas as $indexKelas => $data)
                    <p>{{ $data->kelas->nama }}{{ $indexKelas < count($item->listAtletWithKelas) - 1 ? ',' : '' }}</p>
                @endforeach
            </div>
        </div>
        <button class="cetak-id-card-btn transition-colors duration-300 mt-5 bg-green-500 p-1 rounded text-white mr-3 hover:bg-white border-green-500 border hover:text-green-500" data-atlet-nama="{{ $item->atlet->nama }}" data-index="{{ $index }}">
            Cetak ID Card
        </button>
    </div>
    @endforeach
</div>
<div>
    <div id="id-card-content-manager" class="bg-white shadow-lg rounded-lg max-w-[620px] max-h-[900px]">
        <div class="bg-[#cb1a29] rounded-t-lg flex justify-center items-center py-32 p-10">
            <div>
                <h1 class="text-5xl font-bold text-center text-white py-5">{{ $pertandingan->pertandingan }}</h1>
                <div class="flex justify-center items-center py-2">
                    <img src="{{ asset('storage/foto_manager/'. $manager->user->photo)}}" alt="Your Profile Picture" class="size-64 object-cover">
                </div>
                <div class="text-white text-center">
                    <h1 class="text-5xl font-bold">{{ $manager->user->name }}</h1>
                    <p class="text-3xl font-semibold">{{ $manager->nama }}</p>
                    <p class="text-3xl font-semibold">Manager</p>
                </div>
            </div>
        </div>
    </div>
    <button class="cetak-id-card-btn-manager transition-colors duration-300 mt-5 bg-green-500 p-1 rounded text-white mr-3 hover:bg-white border-green-500 border hover:text-green-500" data-user-nama="{{ $manager->user->nama }}">
        Cetak ID Card
    </button>
</div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>

<script>
$(document).ready(function () {
    $('#table').DataTable();

    $('.cetak-id-card-btn').click(function (event) {
        var index = $(this).data('index');
        var atletNama = $(this).data('atlet-nama');

        event.preventDefault();
        html2canvas(document.querySelector("#id-card-content-" + index), {
            onrendered: function(canvas) {
                const imgData = canvas.toDataURL('image/png');

                const downloadLink = document.createElement('a');
                downloadLink.href = imgData;
                downloadLink.download = `${atletNama}.png`;
                downloadLink.click();
            }
        });
    });

    $('.cetak-id-card-btn-manager').click(function (event) {
        var userNama = $(this).data('user-nama');

        event.preventDefault();
        html2canvas(document.querySelector("#id-card-content-manager"), {
            onrendered: function(canvas) {
                const imgData = canvas.toDataURL('image/png');

                const downloadLink = document.createElement('a');
                downloadLink.href = imgData;
                downloadLink.download = `${userNama}.png`;
                downloadLink.click();
            }
        });
    });
});

</script>
@endsection
