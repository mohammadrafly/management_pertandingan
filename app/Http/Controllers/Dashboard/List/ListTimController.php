<?php

namespace App\Http\Controllers\Dashboard\List;

use App\Http\Controllers\Controller;
use App\Models\List\ListTim;
use Illuminate\Http\Request;

class ListTimController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.list.tim.index', [
            'title' => 'Data List Atlet'
        ]);
    }

    public function create(Request $request)
    {
        return view('pages.dashboard.list.tim.create', [
            'title' => 'Tambah Atlet'
        ]);
    }

    public function update(Request $request, $id)
    {
        return view('pages.dashboard.list.tim.update', [
            'title' => 'Update Atlet'
        ]);
    }

    public function delete($id)
    {
        $tim = ListTim::find($id);

        if (!$tim->delete()){
            return redirect()->route('tim.list.atlet')->with('error', 'Gagal delete atlet!');
        }

        return redirect()->route('tim.list.atlet')->with('success', 'Success delete atlet!');
    }
}
