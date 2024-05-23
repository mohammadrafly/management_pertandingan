<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Atlet;
use App\Models\List\ListTim;
use App\Models\List\ListTimPertandingan;
use App\Models\Pertandingan;
use App\Models\Tim;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public function index()
    {
        $latestPertandingan = Pertandingan::orderBy('dimulai', 'desc')->first();

        $totalAtletPerKategori = ListTim::with(['tim', 'kelas'])
            ->get()
            ->groupBy('tim_id')
            ->map(function ($timGroup) {
                return $timGroup->groupBy('kelas.kategori')
                    ->map(function ($kategoriGroup, $kategori) {
                        return $kategoriGroup->count();
                    });
            })
            ->mapWithKeys(function ($kategoriCounts, $timId) {
                return [$timId => $kategoriCounts->toArray()];
            })
            ->toArray();

        $flattenedCounts = [];
        foreach ($totalAtletPerKategori as $kategoriCounts) {
            foreach ($kategoriCounts as $kategori => $count) {
                $formattedKategori = ucwords(str_replace('_', ' ', $kategori));
                if (!isset($flattenedCounts[$formattedKategori])) {
                    $flattenedCounts[$formattedKategori] = 0;
                }
                $flattenedCounts[$formattedKategori] += $count;
            }
        }

        $totalAtletInPertandingan = 0;
        $pertandinganLabel = '';
        if ($latestPertandingan) {
            $pertandinganLabel = $latestPertandingan->pertandingan;

            $teamsInPertandingan = ListTimPertandingan::where('pertandingan_id', $latestPertandingan->id)
                ->where('status', 'active')
                ->pluck('tim_id');

            $totalAtletInPertandingan = ListTim::whereIn('tim_id', $teamsInPertandingan)
                ->distinct('atlet_id')
                ->count('atlet_id');
        }

        return view('pages.dashboard.index', [
            'title' => 'Dashboard',
            'countdown' => $latestPertandingan,
            'totalUser' => User::count(),
            'totalAtlet' => Atlet::count(),
            'totalTim' => Tim::count(),
            'totalAtletPerKelas' => $flattenedCounts,
            'totalAtletInPertandingan' => [$pertandinganLabel => $totalAtletInPertandingan],
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

        if($request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'. $data->id,
            ]);
            
            if ($validator->fails()) {
                return redirect()->route('profile')->withErrors($validator)->withInput();
            }

            $input = $validator->validated();

            if (!$data->update($input)) {
                return redirect()->route('profile')->with('error', 'Gagal update profile');
            }

            return redirect()->route('profile')->with('success', 'Success update profile');
        }

        return view('pages.dashboard.profile', [
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
