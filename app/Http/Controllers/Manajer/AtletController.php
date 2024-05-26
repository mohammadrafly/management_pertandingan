<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\Atlet;
use App\Models\List\ListAtletInTeam;
use App\Models\Pertandingan;
use App\Models\Tim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AtletController extends Controller
{
    public function index()
    {
        $team = Tim::where('manager', Auth::id())->first();

        if (!$team) {
            return redirect()->route('manajer.my.tim')->with('error', 'Anda tidak memiliki tim! Silahkan daftarkan tim anda terlebih dahulu.');
        }

        $dataAtlet = ListAtletInTeam::with('atlet', 'team', 'listAtletWithKelas')->where('tim_id', $team->id)->get();

        $pertandingan = Pertandingan::orderBy('dimulai', 'desc')->first();

        return view('pages.dashboard.manajer.atlet.index', [
            'title' => 'Data Atlet',
            'data' => $dataAtlet,
        ]);
    }

    public function idCard()
    {
        $team = Tim::where('manager', Auth::id())->first();

        if (!$team) {
            return redirect()->route('manajer.my.tim')->with('error', 'Anda tidak memiliki tim! Silahkan daftarkan tim anda terlebih dahulu.');
        }

        $dataAtlet = ListAtletInTeam::with('atlet', 'team', 'listAtletWithKelas')->where('tim_id', $team->id)->get();

        $pertandingan = Pertandingan::orderBy('dimulai', 'desc')->first();

        return view('pages.dashboard.manajer.atlet.idcard', [
            'title' => 'Data ID Card Atlet',
            'data' => $dataAtlet,
            'pertandingan' => $pertandingan
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string',
                'tempat' => 'required|string',
                'tanggal' => 'required|date',
                'jk' => 'required|in:l,p',
                'bb' => 'required|string',
                'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
                'foto_ktp' => 'image|mimes:jpeg,png,jpg|max:2048',
                'ijazah_karate' => 'file|mimes:pdf|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $findTim = Tim::where('manager', Auth::id())->first();
            $id_tim = $findTim->id;

            $data = $validator->validated();
            $tempatTanggal = $data['tempat'] . ', ' . date('d F Y', strtotime($data['tanggal']));
            $data['ttl'] = $tempatTanggal;

            unset($data['tempat']);
            unset($data['tanggal']);

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fotoName = time() . '_' . $foto->getClientOriginalName();
                $foto->storeAs('fotos', $fotoName, 'public');
                $data['foto'] = $fotoName;
            }

            if ($request->hasFile('foto_ktp')) {
                $file = $request->file('foto_ktp');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('foto_ktp', $fileName, 'public');
                $data['foto_ktp'] = $fileName;
            }

            if ($request->hasFile('ijazah_karate')) {
                $file = $request->file('ijazah_karate');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('ijazah_karate', $fileName, 'public');
                $data['ijazah_karate'] = $fileName;
            }

            $insert = Atlet::create($data);
            if ($insert) {
                ListAtletInTeam::create([
                    'tim_id' => $id_tim,
                    'atlet_id' => $insert->id,
                ]);

                return redirect()->route('manajer.atlet')->with('success', 'Berhasil menambahkan atlet');
            } else {
                return redirect()->route('manajer.atlet')->with('error', 'Gagal menambahkan atlet');
            }
        }

        return view('pages.dashboard.manajer.atlet.create', [
            'title' => 'Tambah Atlet',
        ]);
    }

    public function update(Request $request, $id)
    {
        $atlet = Atlet::find($id);
        if ($request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string',
                'tempat' => 'required|string',
                'tanggal' => 'required|date',
                'jk' => 'required|in:l,p',
                'bb' => 'required|string',
                'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
                'foto_ktp' => 'image|mimes:jpeg,png,jpg|max:2048',
                'ijazah_karate' => 'file|mimes:pdf|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $validator->validated();
            $tempatTanggal = $data['tempat'] . ', ' . date('d F Y', strtotime($data['tanggal']));
            $data['ttl'] = $tempatTanggal;

            unset($data['tempat']);
            unset($data['tanggal']);

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fotoName = time() . '_' . $foto->getClientOriginalName();
                $foto->storeAs('fotos', $fotoName, 'public');
                $data['foto'] = $fotoName;
            }

            if ($request->hasFile('foto_ktp')) {
                $file = $request->file('foto_ktp');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('foto_ktp', $fileName, 'public');
                $data['foto_ktp'] = $fileName;
            }

            if ($request->hasFile('ijazah_karate')) {
                $file = $request->file('ijazah_karate');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('ijazah_karate', $fileName, 'public');
                $data['ijazah_karate'] = $fileName;
            }

            $update = $atlet->update($data);
            if ($update) {
                return redirect()->route('manajer.atlet')->with('success', 'Berhasil update atlet');
            } else {
                return redirect()->route('manajer.atlet')->with('error', 'Gagal update atlet');
            }
        }

        return view('pages.dashboard.manajer.atlet.update', [
            'title' => 'Update Atlet',
            'data' => $atlet,
        ]);
    }

    public function delete($id)
    {
        $atlet = Atlet::find($id);

        if (!$atlet) {
            return redirect()->route('atlet')->with('error', 'Atlet not found!');
        }

        $fotoPath = $atlet->foto;
        $fotoKtpPath = $atlet->foto_ktp;
        $ijazahPath = $atlet->ijazaha_karate;

        if ($fotoPath) {
            $fullFotoPath = storage_path('app/public/fotos/' . $fotoPath);
            if (file_exists($fullFotoPath)) {
                unlink($fullFotoPath);
            }
        }

        if ($fotoKtpPath) {
            $fullFotoKtpPath = storage_path('app/public/foto_ktp/' . $fotoKtpPath);
            if (file_exists($fullFotoKtpPath)) {
                unlink($fullFotoKtpPath);
            }
        }

        if ($ijazahPath) {
            $fullIjazahPath = storage_path('app/public/ijazah_karate/' . $ijazahPath);
            if (file_exists($fullIjazahPath)) {
                unlink($fullIjazahPath);
            }
        }

        $listAtlet = ListAtletInTeam::where('atlet_id', $atlet->id)->first();

        if ($listAtlet && $listAtlet->delete()) {
            $atlet->delete();
            return redirect()->route('manajer.atlet')->with('success', 'Successfully deleted atlet!');
        }

        if (!$listAtlet) {
            $atlet->delete();
            return redirect()->route('manajer.atlet')->with('success', 'Successfully deleted atlet without associated team!');
        }

        return redirect()->route('manajer.atlet')->with('error', 'Failed to delete atlet!');
    }
}
