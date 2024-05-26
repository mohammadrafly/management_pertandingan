<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\Tim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TimController extends Controller
{
    public function index(Request $request)
    {
        $findTeam = Tim::with('user')->where('manager', Auth::id())->first();

        if ($request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string',
                'email' => 'required|email',
                'asal_institusi' => 'required|string',
                'alamat' => 'required|string',
                'no_hp' => 'required|string',
                'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'surat_tugas' => 'file|mimes:pdf,doc,docx|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $validator->validated();
            $data['manager'] = Auth::id();

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fotoExtension = $foto->getClientOriginalExtension();
                $fotoName = time() . '_foto.' . $fotoExtension;
                $foto->storeAs('foto_tim', $fotoName, 'public');
                $data['foto'] = $fotoName;
            }

            if ($request->hasFile('surat_tugas')) {
                $suratTugas = $request->file('surat_tugas');
                $suratTugasExtension = $suratTugas->getClientOriginalExtension();
                $suratTugasName = time() . '_surat.' . $suratTugasExtension;
                $suratTugas->storeAs('surat_tugas', $suratTugasName, 'public');
                $data['surat_tugas'] = $suratTugasName;
            }

            if ($request->filled('id')) {
                $team = Tim::find($request->input('id'));
                if ($team) {
                    $team->update($data);
                    return redirect()->route('manajer.my.tim')->with('success', 'Berhasil memperbarui tim');
                } else {
                    return redirect()->route('manajer.my.tim')->with('error', 'Tim tidak ditemukan');
                }
            } else {
                if (!Tim::create($data)) {
                    return redirect()->route('manajer.my.tim')->with('error', 'Gagal menambahkan tim');
                }
                return redirect()->route('manajer.my.tim')->with('success', 'Berhasil menambahkan tim');
            }
        }

        return view('pages.dashboard.manajer.index', [
            'title' => 'Tim Saya',
            'data' => $findTeam
        ]);
    }
}
