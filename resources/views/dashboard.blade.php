@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Dashboard</h3>

    <div class="row">
        <!-- Mobil Tersedia -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Mobil Tersedia</h5>
                    {{-- <h2>{{ $totalMobilTersedia }}</h2> --}}
                </div>
            </div>
        </div>

        <!-- Pemesanan Saya -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Pemesanan Saya</h5>
                    {{-- <h2>{{ $totalPemesananSaya }}</h2> --}}
                </div>
            </div>
        </div>

        <!-- Status Terakhir -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Status Pemesanan Terakhir</h5>

                    {{-- @if ($pemesananTerakhir)
                        <span class="badge bg-info">
                            {{ ucfirst($pemesananTerakhir->status) }}
                        </span>
                    @else
                        <span class="text-muted">Belum ada pemesanan</span>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
