<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Tampilkan halaman catalog semua mobil
     */
    public function index()
    {
        $cars = Car::paginate(12);
        
        return view('catalog.index', compact('cars'));
    }

    /**
     * Tampilkan detail mobil
     */
    public function show($id)
    {
        $car = Car::findOrFail($id);
        $relatedCars = Car::where('kategori_id', $car->kategori_id)
                          ->where('id', '!=', $id)
                          ->take(4)
                          ->get();

        return view('catalog.show', compact('car', 'relatedCars'));
    }


}
