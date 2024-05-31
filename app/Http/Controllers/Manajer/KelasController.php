<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\Atlet;
use App\Models\Kelas;
use App\Models\List\ListAtletInTeam;
use App\Models\List\ListAtletWithKelas;
use App\Models\Pembayaran;
use App\Models\Pertandingan;
use App\Models\Tim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.manajer.kelas.index', [
            'title' => 'Kelas',
            'data' => Kelas::all(),
        ]);
    }

    public function list($kelas)
    {
        $team = Tim::where('manager', Auth::id())->first();

        if (!$team) {
            return redirect()->route('manajer.my.tim')->with('error', 'Anda tidak memiliki tim! silahkan daftarkan tim anda terlebih dahulu.');
        }

        $currentPertandingan = Pertandingan::orderBy('dimulai', 'desc')->first();

        if (!$currentPertandingan) {
            return redirect()->route('manajer.my.tim')->with('error', 'Tidak ada pertandingan yang tersedia saat ini.');
        }

        $paymentExists = Pembayaran::where('tim_id', $team->id)
                                    ->where('pertandingan_id', $currentPertandingan->id)
                                    ->where('status', '1')
                                    ->exists();

        $timId = $team->id;

        $atlets = ListAtletWithKelas::with(['listAtletInTeam' => function($query) use ($timId) {
                            $query->where('tim_id', $timId);
                        }])
                        ->where('kelas_id', $kelas)
                        ->get();

        $filteredAtlets = $atlets->filter(function($atlet) {
            return $atlet->listAtletInTeam !== null;
        });

        $findKelas = Kelas::find($kelas);
        return view('pages.dashboard.manajer.kelas.list', [
            'title' => 'Daftar Atlet '. $findKelas->nama,
            'id_kelas' => Kelas::find($kelas),
            'data' => $filteredAtlets,
            'sudahBayar' => $paymentExists,
        ]);
    }

    public function create(Request $request, $kelas)
    {
        $team = Tim::where('manager', Auth::id())->first();
        if ($request->isMethod('POST')) {
            $atlet_id = $request->atlet_id;
            $kelas_id = $kelas;

            $atlet = Atlet::findOrFail($atlet_id);

            $findKelas = Kelas::find($kelas_id);

            $weightRange = explode(' - ', $findKelas->bb);
            $weightMin = intval($weightRange[0]);
            $weightMax = intval($weightRange[1]);

            if ($atlet->bb >= $weightMin && $atlet->bb <= $weightMax && $atlet->jk == $findKelas->gender) {
                $exists = ListAtletWithKelas::where('list_atlet_in_team_id', $atlet_id)
                            ->where('kelas_id', $kelas_id)
                            ->exists();

                if ($exists) {
                    return redirect()->route('manajer.kelas.list', $kelas_id)->with('error', 'Atlet sudah ada di dalam kelas.');
                }

                $data = [
                    'list_atlet_in_team_id' => $atlet_id,
                    'kelas_id' => $kelas_id
                ];

                $insert = ListAtletWithKelas::create($data);

                if (!$insert) {
                    return redirect()->route('manajer.kelas.list', $kelas_id)->with('error', 'Gagal menambahkan atlet ke dalam kelas.');
                }

                return redirect()->route('manajer.kelas.list', $kelas_id)->with('success', 'Berhasil menambahkan atlet ke dalam kelas.');
            } else {
                return redirect()->route('manajer.kelas.list', $kelas_id)->with('error', 'Berat badan atlet tidak sesuai atau memiliki gender yang berbeda dengan kelas.');
            }
        }

        return view('pages.dashboard.manajer.kelas.create', [
            'title' => 'Penambahan Atlet ke Kelas',
            'id_kelas' => $kelas,
            'kelas' => Kelas::find($kelas),
            'atlet' => ListAtletInTeam::with('atlet')->where('tim_id', $team->id)->get(),
        ]);
    }

    public function update(Request $request, $kelas, $id)
    {
        $team = Tim::where('manager', Auth::id())->first();
        return view('pages.dashboard.manajer.kelas.update', [
            'title' => 'Pembaruan Kelas untuk Atlet',
            'kelas' => Kelas::all(),
            'atlet' => ListAtletInTeam::with('atlet')->where('tim_id', $team->id)->get(),
        ]);
    }

    public function delete($kelas ,$id)
    {
        $listAtletWithKelas = ListAtletWithKelas::find($id);

        if (!$listAtletWithKelas->delete()){
            return redirect()->route('manajer.kelas', $kelas)->with('error', 'Gagal delete kelas pada atlet!');
        }

        return redirect()->route('manajer.kelas', $kelas)->with('success', 'Success delete kelas pada atlet!');
    }
}
