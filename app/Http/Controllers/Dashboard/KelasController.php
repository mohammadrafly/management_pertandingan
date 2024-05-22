<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.kelas.index', [
            'title' => 'Data Kelas',
            'data' => Kelas::all(),
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $bb = $request->input('bb_min') . ' - ' . $request->input('bb_max');

            $request->merge(['bb' => $bb]);
            
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string',
                'kategori' => 'required|in:kata_perorangan,kata_beregu,kumite_perorangan,kumite_beregu',
                'bb' => 'required|string',
                'img' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $imgName = time() . '_' . $img->getClientOriginalName();
                $img->storeAs('kelas', $imgName, 'public');
                $data['img'] = $imgName;
            }

            $data = $validator->validated();
    
            if (Kelas::create($data)) {
                return redirect()->route('kelas')->with('success', 'Berhasil menambahkan kelas');
            } else {
                return redirect()->route('kelas')->with('error', 'Gagal menambahkan kelas');
            }
        }
    
        return view('pages.dashboard.kelas.create', [
            'title' => 'Tambah Kelas'
        ]);
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::find($id);
        if ($request->isMethod('POST')) {
            $bb = $request->input('bb_min') . ' - ' . $request->input('bb_max');

            $request->merge(['bb' => $bb]);
            
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string',
                'kategori' => 'required|in:kata_perorangan,kata_beregu,kumite_perorangan,kumite_beregu',
                'bb' => 'required|string',
                'img' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $imgName = time() . '_' . $img->getClientOriginalName();
                $img->storeAs('kelas', $imgName, 'public');
                $data['img'] = $imgName;
            }

            $data = $validator->validated();

            if ($kelas->update($data)) {
                return redirect()->route('kelas')->with('success', 'Berhasil update kelas');
            } else {
                return redirect()->route('kelas')->with('error', 'Gagal update kelas');
            }
        }

        return view('pages.dashboard.kelas.update', [
            'title' => 'Update Kelas',
            'data' => $kelas
        ]);
    }

    public function delete($id)
    {
        $kelas = Kelas::find($id);

        if (!$kelas->delete()){
            return redirect()->route('kelas')->with('error', 'Gagal delete kelas!');
        }

        return redirect()->route('kelas')->with('success', 'Success delete kelas!');
    }
}
