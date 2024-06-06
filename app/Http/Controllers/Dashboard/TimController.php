<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\List\ListAtletInTeam;
use App\Models\List\ListTimInPertandingan;
use App\Models\Pembayaran;
use App\Models\Tim;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TimController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.tim.index', [
            'title' => 'Data Tim',
            'data' => Tim::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $tim = Tim::find($id);
        if ($request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string',
                'email' => 'required|email',
                'asal_institusi' => 'required|string',
                'alamat' => 'required|string',
                'manager' => 'required|string|unique:tim,manager,'.$tim->id,
                'no_hp' => 'required|string',
                'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'surat_tugas' => 'file|mimes:pdf,doc,docx|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $validator->validated();
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

            if (!$tim->update($data)) {
                return redirect()->route('tim')->with('error', 'Gagal update tim');
            }

            return redirect()->route('tim')->with('success', 'Berhasil update tim');
        }

        return view('pages.dashboard.tim.update', [
            'title' => 'Update Tim',
            'data' => $tim,
            'manager' => User::where('role', 'manager')->get(),
        ]);
    }

    public function delete($id)
    {
        $tim = Tim::find($id);

        if (!$tim) {
            return redirect()->route('tim')->with('error', 'Tim not found!');
        }

        DB::beginTransaction();
        try {
            // Delete related records in list_atlet_with_kelas via list_atlet_in_team
            $listAtletInTeams = ListAtletInTeam::where('tim_id', $tim->id)->get();
            foreach ($listAtletInTeams as $listAtletInTeam) {
                $listAtletInTeam->listAtletWithKelas()->delete();
            }

            // Delete related records in list_atlet_in_team
            ListAtletInTeam::where('tim_id', $tim->id)->delete();

            // Delete related records in list_tim_in_pertandingan
            ListTimInPertandingan::where('tim_id', $tim->id)->delete();

            // Delete related records in pembayaran
            Pembayaran::where('tim_id', $tim->id)->delete();

            // Delete team photo
            $imagePath = $tim->foto;
            if ($imagePath) {
                $fullImagePath = storage_path('app/public/foto_tim/' . $imagePath);
                if (file_exists($fullImagePath)) {
                    unlink($fullImagePath);
                }
            }

            // Delete team assignment letter
            $documentPath = $tim->surat_tugas;
            if ($documentPath) {
                $fullDocumentPath = storage_path('app/public/surat_tugas/' . $documentPath);
                if (file_exists($fullDocumentPath)) {
                    unlink($fullDocumentPath);
                }
            }

            // Delete the team
            $tim->delete();

            DB::commit();

            return redirect()->route('tim')->with('success', 'Success delete tim!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tim')->with('error', 'Gagal delete tim!');
        }
    }
}
