<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalMobilTersedia = Mobil::where('status', 'tersedia')->count();

        $totalPemesananSaya = Pemesanan::where('user_id', $user->id)->count();

        $pemesananTerakhir = Pemesanan::where('user_id', $user->id)
            ->latest()
            ->first();

        return view('dashboard.index', compact(
            'totalMobilTersedia',
            'totalPemesananSaya',
            'pemesananTerakhir'
        ));
    }
}
