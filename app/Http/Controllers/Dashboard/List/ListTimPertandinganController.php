<?php

namespace App\Http\Controllers\Dashboard\List;

use App\Http\Controllers\Controller;
use App\Models\List\ListTimPertandingan;
use Illuminate\Http\Request;

class ListTimPertandinganController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.list.pertandingan.index', [
            'title' => 'Data List Tim'
        ]);
    }

    public function create(Request $request)
    {
        return view('pages.dashboard.list.pertandingan.create', [
            'title' => 'Tambah Tim'
        ]);
    }

    public function update(Request $request, $id)
    {
        return view('pages.dashboard.list.pertandingan.update', [
            'title' => 'Update Tim'
        ]);
    }

    public function delete($id)
    {
        $pertandingan = ListTimPertandingan::find($id);

        if (!$pertandingan->delete()){
            return redirect()->route('pertandingan.list.tim')->with('error', 'Gagal delete tim!');
        }

        return redirect()->route('pertandingan.list.tim')->with('success', 'Success delete tim!');
    }
}
