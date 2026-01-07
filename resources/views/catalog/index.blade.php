@extends('layouts.app')

@section('content')

<section id="catalog-header" style="text-align: center">
    <div class="container-sm">
        <h1 class="fw-bold mb-2" style="font-size: 48px; color:;">Katalog Mobil</h1>
        <p style="font-size: 18px; opacity: 0.9;">Pilih mobil impian Anda dari koleksi lengkap kami</p>
    </div>
</section>

<section id="catalog-content" style="padding: 60px 0;">
    <div class="container-sm">
        <div class="row">

            <!-- Daftar Mobil -->
            <div class="col-lg-12">
                <!-- Header dengan sorting -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="mb-0"><strong>{{ $cars->total() ?? 0 }} Mobil Tersedia</strong></h5>
                        @if(request('q'))
                            <small class="text-muted">Hasil pencarian untuk: <strong>{{ request('q') }}</strong></small>
                        @endif
                    </div>
                    <div>
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option value="">Urutkan...</option>
                            <option value="price-asc">Harga: Rendah ke Tinggi</option>
                            <option value="price-desc">Harga: Tinggi ke Rendah</option>
                            <option value="newest">Terbaru</option>
                        </select>
                    </div>
                </div>

                <!-- Grid Mobil -->
                <div class="row">
                    @forelse($cars as $car)
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card h-100 shadow-sm" style="border: none; transition: transform 0.3s, box-shadow 0.3s;">
                                <div style="position: relative; height: 250px; overflow: hidden;">
                                    <img src="{{ asset('storage/' . $car->foto) }}" 
                                         class="card-img-top" 
                                         alt="{{ $car->merk }} {{ $car->model }}"
                                         style="height: 100%; object-fit: cover;">
                                    <div style="position: absolute; top: 10px; right: 10px; background: #667eea; color: white; padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                        {{ $car->kategori_mobil_id === 1 ? 'MPV' : ($car->kategori_mobil_id === 2 ? 'SUV' : 'Sedan') }}
                                    </div>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold">{{ $car->merk }} {{ $car->model }}</h5>
                                    <p class="text-muted mb-3" style="font-size: 14px;">
                                        <i class="bi bi-calendar"></i> {{ $car->tahun ?? 'N/A' }}
                                    </p>
                                    
                                    <div class="mb-3" style="font-size: 13px;">
                                        <span class="badge bg-light text-dark">
                                            <i class="bi bi-people"></i> {{ $car->jumlah_kursi ?? 5 }} Kursi
                                        </span>
                                        <span class="badge bg-light text-dark">
                                            <i class="bi bi-fuel-pump"></i> {{ $car->jenis_bahan_bakar ?? 'Bensin' }}
                                        </span>
                                    </div>

                                    <h4 class="text-primary fw-bold mb-3">
                                        Rp {{ number_format($car->harga_sewa, 0, ',', '.') }}<span style="font-size: 14px;">/hari</span>
                                    </h4>

                                    <div class="mt-auto">
                                        <a href="{{ route('catalog.show', $car->id) }}" class="btn btn-primary btn-sm w-100 mb-2">
                                            <i class="bi bi-eye"></i> Lihat Detail
                                        </a>
                                        <a href="{{ route('rental.create', $car->id) }}" class="btn btn-outline-primary btn-sm w-100">
                                            <i class="bi bi-cart"></i> Pesan Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center" role="alert">
                                <h5 class="mb-0">Tidak ada mobil yang sesuai dengan filter Anda</h5>
                                <p class="mb-0 mt-2">Coba ubah filter atau kembali ke halaman utama</p>
                            </div>
                        </div>
                    @endempty
                </div>

                <!-- Pagination -->
                @if($cars->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($cars->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">← Sebelumnya</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $cars->previousPageUrl() }}">← Sebelumnya</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($cars->getUrlRange(1, $cars->lastPage()) as $page => $url)
                                    @if ($page == $cars->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($cars->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $cars->nextPageUrl() }}">Selanjutnya →</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Selanjutnya →</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
    #catalog-content{
        background: linear-gradient(to bottom,  #ffffff 0%, #ebf5ff 100%,#ebf5ff 100%);
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
    }

    .form-range {
        height: 5px;
    }

    .form-range::-webkit-slider-thumb {
        appearance: none;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #667eea;
        cursor: pointer;
        border: none;
    }

    .form-range::-moz-range-thumb {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #667eea;
        cursor: pointer;
        border: none;
    }

    .list-group-item-action {
        color: #667eea;
        padding: 8px 12px;
        font-size: 14px;
    }

    .list-group-item-action:hover {
        background-color: #f0f0f0;
        color: #764ba2;
    }
</style>

<script>
    const minInput = document.getElementById('min-price');
    const maxInput = document.getElementById('max-price');
    const minVal = document.getElementById('min-val');
    const maxVal = document.getElementById('max-val');

    if (minInput) {
        minInput.addEventListener('input', function() {
            minVal.textContent = new Intl.NumberFormat('id-ID').format(this.value);
        });
    }

    if (maxInput) {
        maxInput.addEventListener('input', function() {
            maxVal.textContent = new Intl.NumberFormat('id-ID').format(this.value);
        });
    }
</script>

@endsection