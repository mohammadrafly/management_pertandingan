<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\List\ListAtletWithKelas;
use App\Models\List\ListTimInPertandingan;
use App\Models\Pembayaran;
use App\Models\Pertandingan;
use App\Models\Setting;
use App\Models\Tim;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Auth;

class PertandinganController extends Controller
{
    public function index()
    {
        $team = Tim::where('manager', Auth::id())->first();
        $latestPertandingan = Pertandingan::latest()->first();
    
        if (!$team) {
            return redirect()->route('dashboard')->with('error', 'Anda belum memiliki tim terdaftar.');
        }
        if (!$latestPertandingan) {
            return redirect()->route('dashboard')->with('error', 'Pertandingan tidak tersedia saat ini.');
        }
    
        $pembayaranSaatIni = Pembayaran::where('pertandingan_id', $latestPertandingan->id)
            ->where('tim_id', $team->id)
            ->first();
    
        $joinedPertandingan = ListTimInPertandingan::with('pertandingan')
            ->where('pertandingan_id', $latestPertandingan->id)
            ->where('tim_id', $team->id)
            ->where('status', 'active')
            ->first();
    
        $atlets = ListAtletWithKelas::with(['listAtletInTeam' => function($query) use ($team) {
            $query->where('tim_id', $team->id);
        }])
        ->whereHas('listAtletInTeam', function($query) use ($team) {
            $query->where('tim_id', $team->id);
        })
        ->get();
    
        return view('pages.dashboard.manajer.pertandingan.index', [
            'title' => 'Pertandingan',
            'pembayaran' => Pembayaran::with('team', 'pertandingan')
                ->where('tim_id', $team->id)
                ->where('status', '1')
                ->limit(5)
                ->get(),
            'pertandingan' => $latestPertandingan,
            'countdown' => $latestPertandingan,
            'team_id' => $team->id,
            'pembayaran_saat_ini' => $pembayaranSaatIni,
            'joined_pertandingan' => $joinedPertandingan,
            'atlet' => $atlets
        ]);
    }
    
    public function daftarPertandingan($idPertandingan, $idTeam)
{
    // Check if the team has any athletes
    $atletsCount = ListAtletWithKelas::with(['listAtletInTeam' => function($query) use ($idTeam) {
        $query->where('tim_id', $idTeam);
    }])
    ->whereHas('listAtletInTeam', function($query) use ($idTeam) {
        $query->where('tim_id', $idTeam);
    })
    ->count();

    if ($atletsCount == 0) {
        return redirect()->route('manajer.pertandingan')->with('error', 'Anda harus memiliki atlet untuk mendaftar pertandingan.');
    }

    $existingEntry = ListTimInPertandingan::where('pertandingan_id', $idPertandingan)
        ->where('tim_id', $idTeam)
        ->first();

    if ($existingEntry) {
        return redirect()->route('manajer.pertandingan')->with('error', 'Tim sudah terdaftar untuk pertandingan ini.');
    }

    $create = ListTimInPertandingan::create([
        'pertandingan_id' => $idPertandingan,
        'tim_id' => $idTeam,
        'status' => 'inactive'
    ]);

    if ($create) {
        $hargaPerAtlet = Setting::where('type', 'pembayaran_atlet')->first();
        $hargaPerTim = Setting::where('type', 'pembayaran_tim')->first();
        $totalTagihanAtlets = $atletsCount * $hargaPerAtlet->harga;
        $total = $totalTagihanAtlets + $hargaPerTim->harga;

        $kodePembayaran = $this->generateKodePembayaran();

        Pembayaran::create([
            'pertandingan_id' => $idPertandingan,
            'tim_id' => $idTeam,
            'total' => $total,
            'status' => '0',
            'kode_pembayaran' => $kodePembayaran
        ]);

        return redirect()->route('manajer.pertandingan')->with('success', 'Berhasil daftar!');
    } else {
        return redirect()->route('manajer.pertandingan')->with('error', 'Gagal daftar!');
    }
}


    private function generateKodePembayaran()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $kodePembayaran = '';
        for ($i = 0; $i < 10; $i++) {
            $kodePembayaran .= $characters[rand(0, strlen($characters) - 1)];
        }
        while (Pembayaran::where('kode_pembayaran', $kodePembayaran)->exists()) {
            $kodePembayaran = '';
            for ($i = 0; $i < 10; $i++) {
                $kodePembayaran .= $characters[rand(0, strlen($characters) - 1)];
            }
        }
        return $kodePembayaran;
    }

    public function bayarDanAktivasi($idPertandingan, $idTeam)
    {
        $data = Pembayaran::with('team', 'pertandingan')->where('pertandingan_id', $idPertandingan)->where('tim_id', $idTeam)->where('status', '0')->first();
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $grossAmount = intval($data->total);
        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . time(),
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $data->team->nama,
                'email' => $data->team->email,
                'phone' => $data->team->no_hp,
                'billing_address' => [
                    'address' => $data->team->alamat,
                ],
            ],
            'item_details' => [
                [
                'id' => $data->kode_pembayaran,
                'price' => $grossAmount,
                'quantity' => 1,
                'name' => 'Bayar Pendaftaran Pertandingan'. $data->pertandingan->pertandingan
                ],
            ],
            'callbacks' => [
                'finish' => 'http://localhost:8080/api/callback/success/'.$data->kode_pembayaran
            ]
        ];

        return response()->json(Snap::getSnapToken($params));
    }

    public function callbackSuccess($kodePembayaran)
    {
        $pembayaran = Pembayaran::with('pertandingan')->where('kode_pembayaran', $kodePembayaran)->first();
        $pertandingan = ListTimInPertandingan::where('pertandingan_id', $pembayaran->pertandingan->id)->where('tim_id', $pembayaran->tim_id)->where('status', 'inactive')->first();

        $pembayaran->update(['status' => '1']);
        $pertandingan->update(['status' => 'active']);

        return redirect()->route('manajer.pertandingan')->with('success', 'Berhasil melakukan pembayaran');
    }
}
