<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index($team)
    {
        $riwayat = Pembayaran::with('pertandingan')->where('tim_id', $team)->get();

        return view('pages.dashboard.manajer.pembayaran', [
            'title' => 'Riwayat Pembayaran',
            'data' => $riwayat,
        ]);
    }
}
