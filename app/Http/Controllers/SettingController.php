<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.setting.index', [
            'title' => 'Data Setting Harga',
            'data' => Setting::all()
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'type' => 'required|in:pembayaran_tim,pembayaran_atlet',
                'harga' => 'required|string',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $validator->validated();

            if (Setting::create($data)) {
                return redirect()->route('setting')->with('success', 'Berhasil menambahkan setting');
            } else {
                return redirect()->route('setting')->with('error', 'Gagal menambahkan setting');
            }
        }

        return view('pages.dashboard.setting.create', [
            'title' => 'Tambah Setting Harga'
        ]);
    }

    public function update(Request $request, $id)
    {
        $setting = Setting::find($id);
        if ($request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'type' => 'required|in:pembayaran_tim,pembayaran_atlet',
                'harga' => 'required|string',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $validator->validated();

            if ($setting->update($data)) {
                return redirect()->route('setting')->with('success', 'Berhasil update setting');
            } else {
                return redirect()->route('setting')->with('error', 'Gagal update setting');
            }
        }

        return view('pages.dashboard.setting.update', [
            'title' => 'Update Setting',
            'data' => $setting,
        ]);
    }

    public function delete($id)
    {
        $setting = Setting::find($id);

        if ($setting->delete()) {
            return redirect()->route('setting')->with('success', 'Successfully deleted setting!');
        }
    
        return redirect()->route('setting')->with('error', 'Failed to delete setting!');
    }
}
