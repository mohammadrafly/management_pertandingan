<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Pertandingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PertandinganController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.pertandingan.index', [
            'title' => 'Data Pertandingan',
            'data' => Pertandingan::all()
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'pertandingan' => 'required|string',
                'dimulai' => 'required|string',
                'diakhiri' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $validator->validated();
            $data['status'] = '0';

            $overlap = Pertandingan::where('dimulai', '<=', $data['diakhiri'])
                                    ->where('diakhiri', '>=', $data['dimulai'])
                                    ->exists();

            if ($overlap) {
                return redirect()->back()->with('error', 'Pertandingan lain sudah terjadwal dalam rentang waktu yang sama. Silakan pilih rentang waktu yang berbeda.')->withInput();
            }

            if (!Pertandingan::create($data)) {
                return redirect()->route('pertandingan')->with('error', 'Gagal menambahkan pertandingan');
            }

            return redirect()->route('pertandingan')->with('success', 'Berhasil menambahkan pertandingan');
        }

        return view('pages.dashboard.pertandingan.create', [
            'title' => 'Tambah Pertandingan'
        ]);
    }

    public function update(Request $request, $id)
    {
        $pertandingan = Pertandingan::find($id);
        if ($request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'pertandingan' => 'required|string',
                'dimulai' => 'string',
                'diakhiri' => 'string',
                'status' => 'in:1,0'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $validator->validated();

            $update = $pertandingan->update($data);
            if (!$update) {
                return redirect()->route('pertandingan')->with('error', 'Gagal update pertandingan');
            }

            return redirect()->route('pertandingan')->with('success', 'Berhasil update pertandingan');
        }

        return view('pages.dashboard.pertandingan.update', [
            'title' => 'Update Pertandingan',
            'data' => $pertandingan,
        ]);
    }

    public function delete($id)
    {
        $pertandingan = Pertandingan::find($id);

        if (!$pertandingan->delete()){
            return redirect()->route('pertandingan')->with('error', 'Gagal delete pertandingan!');
        }

        return redirect()->route('pertandingan')->with('success', 'Success delete pertandingan!');
    }
}
