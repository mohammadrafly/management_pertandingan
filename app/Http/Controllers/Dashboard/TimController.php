<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Tim;
use App\Models\User;
use Illuminate\Http\Request;
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

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string',
                'email' => 'required|email',
                'asal_institusi' => 'required|string',
                'alamat' => 'required|string',
                'manager' => 'required|string|unique:tim,manager',
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
                $fotoName = time() . '_' . $foto->getClientOriginalName();
                $foto->storeAs('fotos', $fotoName, 'public');
                $data['foto'] = $fotoName;
            }
    
            if ($request->hasFile('surat_tugas')) {
                $suratTugas = $request->file('surat_tugas');
                $suratTugasName = time() . '_' . $suratTugas->getClientOriginalName();
                $suratTugas->storeAs('surat_tugas', $suratTugasName, 'public');
                $data['surat_tugas'] = $suratTugasName;
            }
            
            if (!Tim::create($data)) {
                return redirect()->route('tim')->with('error', 'Gagal menambahkan tim');
            }
    
            return redirect()->route('tim')->with('success', 'Berhasil menambahkan tim');
        }
    
        return view('pages.dashboard.tim.create', [
            'title' => 'Tambah Tim',
            'manager' => User::where('role', 'manager')->get(),
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
                $fotoName = time() . '_' . $foto->getClientOriginalName();
                $foto->storeAs('fotos', $fotoName, 'public');
                $data['foto'] = $fotoName;
            }
    
            if ($request->hasFile('surat_tugas')) {
                $suratTugas = $request->file('surat_tugas');
                $suratTugasName = time() . '_' . $suratTugas->getClientOriginalName();
                $suratTugas->storeAs('surat_tugas', $suratTugasName, 'public');
                $data['surat_tugas'] = $suratTugasName;
            }
            
            if (!$tim->update($data)) {
                return redirect()->route('tim')->with('error', 'Gagal update tim');
            }
    
            return redirect()->route('tim')->with('success', 'Berhasil update tim');
        }

        return view('pages.dashboard.tim.update', [
        //dd([
            'title' => 'Update Tim',
            'data' => $tim,
            'manager' => User::where('role', 'manager')->get(),
        ]);
    }

    public function delete($id)
    {
        $tim = Tim::find($id);

        if (!$tim->delete()){
            return redirect()->route('tim')->with('error', 'Gagal delete tim!');
        }

        return redirect()->route('tim')->with('success', 'Success delete tim!');
    }
}
