<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Atlet;
use App\Models\List\ListAtletWithKelas as ListListAtletWithKelas;
use App\Models\List\ListTimInPertandingan;
use App\Models\Pertandingan;
use App\Models\Tim;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public function index()
    {
        $latestPertandingan = Pertandingan::orderBy('dimulai', 'desc')->first();
        $atletCountByKelas = ListListAtletWithKelas::with('kelas')
            ->select('kelas_id', DB::raw('count(*) as total'))
            ->groupBy('kelas_id')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->kelas->nama => $item->total];
            })
            ->toArray();


        $totalTimInPertandingan = ListTimInPertandingan::with('pertandingan')->select('pertandingan_id', DB::raw('count(*) as total'))
            ->groupBy('pertandingan_id')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->pertandingan->pertandingan => $item->total];
            })
            ->toArray();

        return view('pages.dashboard.index', [
        //dd([
            'title' => 'Dashboard',
            'countdown' => $latestPertandingan,
            'totalUser' => User::count(),
            'totalAtlet' => Atlet::count(),
            'totalTim' => Tim::count(),
            'totalAtletPerKelas' => $atletCountByKelas,
            'totalTimInPertandingan' => $totalTimInPertandingan,
        ]);
    }

    public function Logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil keluar dari sistem.');
    }

    public function profile(Request $request)
    {
        $data = User::find(Auth::id());

        if ($request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $data->id,
                'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $input = $validator->validated();

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photoName = time() . '_foto_manager';
                $photo->storeAs('public/foto_manager', $photoName);
                $input['photo'] = $photoName;
            }

            if (!$data->update($input)) {
                return redirect()->back()->with('error', 'Gagal update profile');
            }

            return redirect()->back()->with('success', 'Success update profile');
        }

        return view('pages.dashboard.profile', [
        //dd([
            'title' => 'Update Profile',
            'data' => $data
        ]);
    }

    public function password(Request $request)
    {
        if ($request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'required|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect()->route('profile')->withErrors($validator)->withInput();
            }

            $validator->validated();

            $user = User::find(Auth::id());
            $old_password = $request->old_password;
            $new_password = $request->new_password;

            if (!Hash::check($old_password, $user->password)) {
                return redirect()->route('profile')->with('error', 'Gagal update password: Password lama salah.');
            }

            $user->password = Hash::make($new_password);
            $user->save();

            return redirect()->route('profile')->with('success', 'Berhasil update password');
        }
    }
}
