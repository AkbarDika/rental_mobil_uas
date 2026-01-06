@extends('layouts.app')

@section('content')

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" style="padding: 20px 0; background: #f5f5f5;">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Katalog</a></li>
            <li class="breadcrumb-item active">{{ $car->merk }} {{ $car->model }}</li>
        </ol>
    </div>
</nav>

<section id="detail-catalog" style="padding: 60px 0;">
    <div class="container">
        <div class="row">
            <!-- Gambar -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm" style="border: none;">
                    <img src="{{ asset('storage/' . $car->foto) }}" 
                         class="card-img-top" 
                         alt="{{ $car->merk }} {{ $car->model }}"
                         style="height: 500px; object-fit: cover;">
                </div>
                
                <!-- Thumbnails -->
                <div class="mt-3">
                    <div class="row g-2">
                        <div class="col-3">
                            <img src="{{ asset('storage/' . $car->foto) }}" 
                                 class="img-fluid rounded" 
                                 style="cursor: pointer; height: 100px; object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Mobil -->
            <div class="col-lg-6">
                <div class="mb-4">
                    <span class="badge bg-primary mb-2">{{ $car->kategori_mobil_id === 1 ? 'MPV' : ($car->kategori_mobil_id === 2 ? 'SUV' : 'Sedan') }}</span>
                    <h1 class="fw-bold mb-2">{{ $car->merk }} {{ $car->model }}</h1>
                    <p class="text-muted mb-3">
                        <i class="bi bi-calendar"></i> Tahun: {{ $car->tahun ?? 'N/A' }}
                    </p>

                    <!-- Rating -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center">
                            <div class="rating">
                                <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                <i class="bi bi-star-half" style="color: #ffc107;"></i>
                            </div>
                            <span class="ms-2 text-muted">(124 ulasan)</span>
                        </div>
                    </div>

                    <!-- Harga -->
                    <div class="mb-4">
                        <h2 class="text-primary fw-bold">Rp {{ number_format($car->harga_sewa, 0, ',', '.') }}<span style="font-size: 18px;">/hari</span></h2>
                        <small class="text-muted">Harga belum termasuk biaya asuransi dan pajak</small>
                    </div>

                    <!-- Spesifikasi -->
                    <div class="card shadow-sm mb-4" style="border: none;">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 fw-bold">Spesifikasi Kendaraan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <p class="text-muted mb-1">Jumlah Kursi</p>
                                    <h6 class="fw-bold">{{ $car->jumlah_kursi ?? 5 }} Kursi</h6>
                                </div>
                                <div class="col-6 mb-3">
                                    <p class="text-muted mb-1">Jenis Bahan Bakar</p>
                                    <h6 class="fw-bold">{{ $car->jenis_bahan_bakar ?? 'Bensin' }}</h6>
                                </div>
                                <div class="col-6 mb-3">
                                    <p class="text-muted mb-1">Transmisi</p>
                                    <h6 class="fw-bold">Otomatis</h6>
                                </div>
                                <div class="col-6 mb-3">
                                    <p class="text-muted mb-1">Tipe Kabin</p>
                                    <h6 class="fw-bold">SUV 5 Pintu</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fitur -->
                    <div class="card shadow-sm mb-4" style="border: none;">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 fw-bold">Fitur & Keamanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <p><i class="bi bi-check-circle-fill text-success"></i> AC</p>
                                </div>
                                <div class="col-6 mb-2">
                                    <p><i class="bi bi-check-circle-fill text-success"></i> Power Steering</p>
                                </div>
                                <div class="col-6 mb-2">
                                    <p><i class="bi bi-check-circle-fill text-success"></i> Airbag</p>
                                </div>
                                <div class="col-6 mb-2">
                                    <p><i class="bi bi-check-circle-fill text-success"></i> ABS</p>
                                </div>
                                <div class="col-6 mb-2">
                                    <p><i class="bi bi-check-circle-fill text-success"></i> Bluetooth</p>
                                </div>
                                <div class="col-6 mb-2">
                                    <p><i class="bi bi-check-circle-fill text-success"></i> Camera Mundur</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-lg mb-2" data-bs-toggle="modal" data-bs-target="#modalBooking">
                            <i class="bi bi-calendar-check"></i> Pesan Sekarang
                        </button>
                        <button class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-heart"></i> Tambah ke Favorit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-5">

        <!-- Deskripsi -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-3">Deskripsi Kendaraan</h4>
                <p class="text-muted">
                    {{ $car->merk }} {{ $car->model }} adalah pilihan sempurna untuk kebutuhan transportasi Anda. 
                    Dengan desain modern, fitur lengkap, dan kenyamanan maksimal, mobil ini cocok untuk berbagai 
                    keperluan mulai dari liburan keluarga hingga perjalanan bisnis. Kami menjamin kendaraan dalam 
                    kondisi prima dengan perawatan rutin dan asuransi lengkap.
                </p>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedCars->count() > 0)
            <div class="row">
                <div class="col-12">
                    <h4 class="fw-bold mb-4">Mobil Serupa Lainnya</h4>
                </div>
                @foreach($relatedCars as $relatedCar)
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="card h-100 shadow-sm" style="border: none; transition: transform 0.3s;">
                            <img src="{{ asset('storage/' . $relatedCar->foto) }}" 
                                 class="card-img-top" 
                                 alt="{{ $relatedCar->merk }} {{ $relatedCar->model }}"
                                 style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $relatedCar->merk }} {{ $relatedCar->model }}</h5>
                                <h6 class="text-primary fw-bold">Rp {{ number_format($relatedCar->harga_sewa, 0, ',', '.') }}/hari</h6>
                                <a href="{{ route('catalog.show', $relatedCar->id) }}" class="btn btn-primary btn-sm w-100 mt-2">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- Modal Booking -->
<div class="modal fade" id="modalBooking" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pesan {{ $car->merk }} {{ $car->model }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Awal Sewa</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Akhir Sewa</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi Penjemputan</label>
                        <select class="form-select">
                            <option selected>Pilih lokasi...</option>
                            <option>Bandara Husein Sastranegara</option>
                            <option>Pusat Kota</option>
                            <option>Stasiun Kereta</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan Tambahan</label>
                        <textarea class="form-control" rows="3" placeholder="Tulis catatan jika ada..."></textarea>
                    </div>
                    <div class="alert alert-info">
                        <strong>Estimasi Total:</strong> Rp {{ number_format($car->harga_sewa * 3, 0, ',', '.') }} (3 hari)
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Lanjutkan ke Pembayaran</button>
            </div>
        </div>
    </div>
</div>

<style>
    .card:hover {
        transform: translateY(-5px);
    }
</style>

@endsection
