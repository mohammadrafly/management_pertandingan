<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $credentials = $validator->validated();
    
            if ($validator->fails()) {
                return redirect()->route('login')->withErrors($validator)->withInput();
            }
    
            if (!Auth::attempt($credentials)) {
                return redirect()->route('login')->withErrors($validator)->withInput()->with('error', 'Gagal login.');
            }
    
            return redirect()->route('dashboard')->with('success', 'Berhasil login.');
        }
    

        return view('pages.auth.login', [
            'title' => 'Login'
        ]);
    }

    public function register(Request $request)
    {
        if ($request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect()->route('register')->withErrors($validator)->withInput();
            }

            $data = $validator->validated();
            $data['role'] = 'manager';

            if (!User::create($data)) {
                return redirect()->route('register')->with('error', 'Gagal Register');
            }

            return redirect()->route('login')->with('success', 'Berhasil register.');
        }

        return view('pages.auth.register', [
            'title' => 'Register'
        ]);
    }
}
