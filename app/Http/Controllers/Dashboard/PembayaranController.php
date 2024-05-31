<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.pembayaran.index', [
            'title' => 'Data Pembayaran',
            'data' => Pembayaran::with('pertandingan', 'team')->get(),
        ]);
    }

    public function create(Request $request)
    {
        return view('pages.dashboard.pembayaran.create', [
            'title' => 'Tambah Pembayaran'
        ]);
    }

    public function update(Request $request, $id)
    {
        return view('pages.dashboard.pembayaran.update', [
            'title' => 'Update Pembayaran'
        ]);
    }

    public function delete($id)
    {
        $pembayaran = Pembayaran::find($id);

        if (!$pembayaran->delete()){
            return redirect()->route('pembayaran')->with('error', 'Gagal delete pembayaran!');
        }

        return redirect()->route('pembayaran')->with('success', 'Success delete pembayaran!');
    }
}
