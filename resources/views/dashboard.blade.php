@extends('layouts.app')

@section('content')
@php
use Illuminate\Support\Facades\Storage;
@endphp

<section id="section-1" style="
    background-image: url('{{ asset('storage/rental/fotomaster.png') }}');
    height: 550px;              /* Set tinggi sesuai ukuran gambar */
    width: 100%;                /* Pastikan lebar penuh */
    background-size: contain;    /* Atau gunakan '100% 100%' jika ingin paksa penuh ke samping */
    background-position: center;
    background-repeat: no-repeat;
    margin: 0;
    padding: 0;">

    <div class="container">
        {{-- <h1 class="fw-bold mb-4 judul">RENTAL MOBIL JAYA</h1>
        <p>Butuh alat transportasi saat berlibur bersama keluarga? RENTAL JAYA SOLUSINYA</p> --}}
    </div>
</section>

<section id="section-2">
    <div class="container-sm">
        <h1 class="subjudul">Best Seller!</h1>
        <div class="row mt-4">
            @foreach ($cars as $car)
                <div class="col-md-3 mb-3">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $car->foto) }}"
                            class="card-img-top"
                            style="height:200px;object-fit:cover">
                        <div class="card-body d-flex flex-column">
                            <h5>{{ $car->merk }} {{ $car->model }}</h5>
                            <p>Rp {{ number_format($car->harga_sewa,0,',','.') }} / hari</p>
                            <a href="
                            {{-- {{ route('rent.create', $car->id) }} --}}
                             " class="btn btn-primary mt-auto">Sewa Sekarang</a>    
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row pb-5">
            <div style="text-align: center; margin-top: 50px;">
                <a href="{{ route('catalog.index') }}" class="btn-gabung">
                    Lihat Selengkapnya
                </a>
            </div>
        </div>
        <hr>
    </div>
</section>

<section id="section-3">
    <div class="container-sm">
        <h1 class="subjudul">Tentang Kami</h1>
        <div class="row" style="padding-bottom: 100px">
            <div class="col-6">
                <img src="{{ asset('storage/rental/tentang.png') }}" alt="Tentang" style="width: 600px">
            </div>
            <div class="col-6">
                <p class="mt-4 p-tentang">RENTAL MOBIL JAYA adalah penyedia layanan rental mobil terpercaya yang telah beroperasi sejak tahun 2010. Kami menyediakan berbagai jenis mobil berkualitas untuk memenuhi kebutuhan transportasi Anda, baik untuk keperluan pribadi, bisnis, maupun liburan. Dengan armada yang terawat dan layanan pelanggan yang ramah, kami berkomitmen untuk memberikan pengalaman rental mobil terbaik bagi setiap pelanggan kami.</p>
            </div>
        </div>
    </div>
</section>

@endsection
