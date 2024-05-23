<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Atlet;
use App\Models\Kelas;
use App\Models\List\ListTim;
use App\Models\Tim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AtletController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.atlet.index', [
            'title' => 'Data Atlet',
            'data' => Atlet::all(),
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
    
            $id_tim = $request->tim_id;
            $id_kelas = $request->kelas_id;

            $findKelas = Kelas::where('id', $id_kelas)->first();
            //dd($findKelas);
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
                ListTim::create([
                    'tim_id' => $id_tim,
                    'atlet_id' => $insert->id,
                    'kelas_id' => $id_kelas,
                ]);

                return redirect()->route('atlet')->with('success', 'Berhasil menambahkan atlet');
            } else {
                return redirect()->route('atlet')->with('error', 'Gagal menambahkan atlet');
            }
        }
        
        return view('pages.dashboard.atlet.create', [
            'title' => 'Tambah Atlet',
            'tim' => Tim::all(),
            'kelas' => Kelas::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $atlet = Atlet::with('ListTim')->find($id);
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
    
            $id_tim = $request->tim_id;
            $id_kelas = $request->kelas_id;
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
                ListTim::where('atlet_id', $atlet->id)->update([
                    'tim_id' => $id_tim,
                    'kelas_id' => $id_kelas
                ]);

                return redirect()->route('atlet')->with('success', 'Berhasil update atlet');
            } else {
                return redirect()->route('atlet')->with('error', 'Gagal update atlet');
            }
        }

        return view('pages.dashboard.atlet.update', [
            'title' => 'Update Atlet',
            'tim' => Tim::all(),
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

        $listTim = ListTim::where('atlet_id', $atlet->id)->first();

        if ($listTim && $listTim->delete()) {
            $atlet->delete();
            return redirect()->route('atlet')->with('success', 'Successfully deleted atlet!');
        }
    
        if (!$listTim) {
            $atlet->delete();
            return redirect()->route('atlet')->with('success', 'Successfully deleted atlet without associated team!');
        }
    
        return redirect()->route('atlet')->with('error', 'Failed to delete atlet!');
    }    
}
