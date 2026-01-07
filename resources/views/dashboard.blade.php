@extends('layouts.app')

@section('content')
@php
use Illuminate\Support\Facades\Storage;
@endphp

<section id="section-1" >
    <img src="{{ asset('storage/rental/fotomaster.png') }}" alt="" style="width: 100%; height: 400px;">

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
                            <a href="{{ route('rental.create', $car->id) }}" class="btn btn-primary mt-auto">Sewa Sekarang</a>    
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

<style>
    #section-1 h1 {
    margin-top: 100px;
    font-size: 48px;
    font-weight: bold;
    text-align: center;
}

#section-1 p {
    font-size: 18px;
    text-align: center;
    margin-top: 10px;
    padding-bottom: 120px;
}
#section-2 {
    /* Gradasi dari biru muda sangat lembut ke putih murni */
    background: linear-gradient(to bottom,  #ffffff 0%, #ebf5ff 100%);
    padding-bottom: 80px ;
}
#section-3{
    background: linear-gradient(to bottom,  #ebf5ff 0%, #ffffff 100%);
    padding-bottom: 80px ;
}

.subjudul {
    padding-top:50px;
    padding-bottom: 40px;
    font-size: 40px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
}
.p-tentang{
    font-size: 16px;
    padding-bottom: 100px;
}

.btn-gabung {
    background-color: #3498db; /* Warna Biru Muda Utama */
    color: #ffffff;            /* Warna Teks Putih */
    padding: 12px 30px;        /* Ukuran tombol */
    border-radius: 50px;       /* Membuat tombol bulat (pill) */
    border: none;              /* Menghilangkan border bawaan */
    font-weight: 600;          /* Membuat teks sedikit tebal */
    font-size: 16px;
    display: inline-flex;      /* Agar icon dan teks sejajar */
    align-items: center;
    gap: 10px;                 /* Jarak antara icon buku dan teks */
    text-decoration: none;     /* Menghilangkan garis bawah link */
    transition: all 0.3s ease; /* Transisi halus saat hover */
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3); /* Shadow lembut biru */
    cursor: pointer;
    
}
/* Efek Hover (Saat kursor di atas tombol) */
.btn-gabung:hover {
    background-color: #2980b9; /* Biru yang sedikit lebih gelap saat dihover */
    transform: translateY(-3px); /* Tombol sedikit terangkat ke atas */
    box-shadow: 0 6px 20px rgba(52, 152, 219, 0.5); /* Shadow lebih tegas */
    color: #ffffff;
}
/* Efek Active (Saat tombol diklik) */
.btn-gabung:active {
    transform: translateY(-1px);
}

</style>

@endsection
