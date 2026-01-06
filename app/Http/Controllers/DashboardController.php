<?php

namespace App\Http\Controllers;

use App\Models\Car;

class DashboardController extends Controller
{
    public function index()
    {
        $cars = Car::where('status', 'tersedia')->take(4)->get();

        return view('dashboard', compact('cars'));
    }
}

