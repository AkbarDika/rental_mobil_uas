@extends('layouts.admin')

@section('content')

<div class="page-title">
    <i class="bi bi-graph-up"></i>
    <h2 style="margin: 0;">Dashboard Admin</h2>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="admin-stat-box stat-primary">
            <div style="text-align: center;">
                <i class="bi bi-car-front" style="font-size: 32px; color: #667eea;"></i>
            </div>
            <h3>150</h3>
            <p>Total Mobil</p>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="admin-stat-box stat-success">
            <div style="text-align: center;">
                <i class="bi bi-check-circle" style="font-size: 32px; color: #48bb78;"></i>
            </div>
            <h3>45</h3>
            <p>Pemesanan Aktif</p>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="admin-stat-box stat-warning">
            <div style="text-align: center;">
                <i class="bi bi-credit-card" style="font-size: 32px; color: #ed8936;"></i>
            </div>
            <h3>Rp 25.5M</h3>
            <p>Total Pendapatan</p>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="admin-stat-box stat-danger">
            <div style="text-align: center;">
                <i class="bi bi-people" style="font-size: 32px; color: #f56565;"></i>
            </div>
            <h3>320</h3>
            <p>Total Pengguna</p>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="row">
    <!-- Recent Orders -->
    <div class="col-lg-8">
        <div class="admin-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h5 style="margin: 0; font-weight: bold;">
                    <i class="bi bi-calendar-check"></i> Pemesanan Terbaru
                </h5>
                <a href="#" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead style="background-color: #f5f7fa;">
                        <tr>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Mobil</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#PES001</td>
                            <td>Budi Santoso</td>
                            <td>Honda Jazz 2023</td>
                            <td>06 Jan 2026</td>
                            <td>
                                <span class="badge bg-success">Aktif</span>
                            </td>
                        </tr>
                        <tr>
                            <td>#PES002</td>
                            <td>Siti Nurhaliza</td>
                            <td>Toyota Avanza</td>
                            <td>05 Jan 2026</td>
                            <td>
                                <span class="badge bg-warning">Pending</span>
                            </td>
                        </tr>
                        <tr>
                            <td>#PES003</td>
                            <td>Ahmad Wijaya</td>
                            <td>Daihatsu Xenia</td>
                            <td>04 Jan 2026</td>
                            <td>
                                <span class="badge bg-info">Selesai</span>
                            </td>
                        </tr>
                        <tr>
                            <td>#PES004</td>
                            <td>Rizki Pratama</td>
                            <td>Nissan Livina</td>
                            <td>03 Jan 2026</td>
                            <td>
                                <span class="badge bg-info">Selesai</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Info -->
    <div class="col-lg-4">
        <div class="admin-card">
            <h5 style="margin-bottom: 20px; font-weight: bold;">
                <i class="bi bi-lightning"></i> Aksi Cepat
            </h5>
            <a href="#" class="btn btn-outline-primary w-100 mb-2">
                <i class="bi bi-plus-circle"></i> Tambah Mobil Baru
            </a>
            <a href="#" class="btn btn-outline-primary w-100 mb-2">
                <i class="bi bi-pencil-square"></i> Kelola Pemesanan
            </a>
            <a href="#" class="btn btn-outline-primary w-100 mb-2">
                <i class="bi bi-file-earmark-pdf"></i> Buat Laporan
            </a>
            <a href="#" class="btn btn-outline-primary w-100">
                <i class="bi bi-gear"></i> Pengaturan Sistem
            </a>
        </div>

        <div class="admin-card">
            <h5 style="margin-bottom: 20px; font-weight: bold;">
                <i class="bi bi-info-circle"></i> Informasi Sistem
            </h5>
            <p style="margin: 10px 0; font-size: 14px;">
                <strong>Versi Aplikasi:</strong> 1.0.0
            </p>
            <p style="margin: 10px 0; font-size: 14px;">
                <strong>Database:</strong> MySQL
            </p>
            <p style="margin: 10px 0; font-size: 14px;">
                <strong>Last Update:</strong> 06 Jan 2026
            </p>
            <p style="margin: 10px 0; font-size: 14px;">
                <strong>Status:</strong> <span class="badge bg-success">Online</span>
            </p>
        </div>
    </div>
</div>

<!-- Chart Section (Optional) -->
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="admin-card">
            <h5 style="margin-bottom: 20px; font-weight: bold;">
                <i class="bi bi-graph-up"></i> Statistik Pendapatan (6 Bulan Terakhir)
            </h5>
            <div style="height: 300px; background: #f5f7fa; border-radius: 5px; display: flex; align-items: center; justify-content: center; color: #999;">
                Grafik dapat ditambahkan dengan Chart.js atau library serupa
            </div>
        </div>
    </div>
</div>

@endsection
