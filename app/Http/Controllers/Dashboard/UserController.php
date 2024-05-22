<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.user.index', [
            'title' => 'Data User',
            'data' => User::all()
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'role' => 'required',
                'password' => 'required|confirmed'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $validator->validated();

            $data['password'] = Hash::make($data['password']);

            if (!User::create($data)) {
                return redirect()->route('user')->with('error', 'Gagal menambahkan user');
            }

            return redirect()->route('user')->with('success', 'Berhasil menambahkan user');
        }

        return view('pages.dashboard.user.create', [
            'title' => 'Tambah User'
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if ($request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'role' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $validator->validated();

            if (!$user->update($data)) {
                return redirect()->route('user')->with('error', 'Gagal update user');
            }

            return redirect()->route('user')->with('success', 'Berhasil update user');
        }

        return view('pages.dashboard.user.update', [
            'title' => 'Update User',
            'data' => $user,
        ]);
    }

    public function delete($id)
    {
        $user = User::find($id);

        if (!$user->delete()){
            return redirect()->route('user')->with('error', 'Gagal delete user!');
        }

        return redirect()->route('user')->with('success', 'Success delete user!');
    }
}
