<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * Halaman kelola mobil
     */
    public function cars()
    {
        // TODO: Tambahkan logika untuk menampilkan data mobil
        return view('admin.cars.index');
    }

    /**
     * Halaman kelola pemesanan
     */
    public function orders()
    {
        // TODO: Tambahkan logika untuk menampilkan data pemesanan
        return view('admin.orders.index');
    }

    /**
     * Halaman kelola pembayaran
     */
    public function payments()
    {
        // TODO: Tambahkan logika untuk menampilkan data pembayaran
        return view('admin.payments.index');
    }

    /**
     * Halaman kelola pengguna
     */
    public function users()
    {
        // TODO: Tambahkan logika untuk menampilkan data pengguna
        return view('admin.users.index');
    }
}
