@extends('layouts.admin')

@section('content')

<div class="page-title">
    <i class="bi bi-calendar-check"></i>
    <h2 style="margin: 0;">Kelola Pemesanan</h2>
</div>

<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h5 style="margin: 0; font-weight: bold;">Daftar Pemesanan</h5>
        <button class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Tambah Pemesanan
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead style="background-color: #f5f7fa;">
                <tr>
                    <th>ID Pemesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>Mobil</th>
                    <th>Tanggal Sewa</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#PES001</td>
                    <td>Budi Santoso</td>
                    <td>Honda Jazz</td>
                    <td>06 Jan 2026</td>
                    <td>08 Jan 2026</td>
                    <td><span class="badge bg-success">Aktif</span></td>
                    <td>Rp 1.500.000</td>
                    <td>
                        <button class="btn btn-sm btn-info"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>#PES002</td>
                    <td>Siti Nurhaliza</td>
                    <td>Toyota Avanza</td>
                    <td>07 Jan 2026</td>
                    <td>10 Jan 2026</td>
                    <td><span class="badge bg-warning">Pending</span></td>
                    <td>Rp 1.350.000</td>
                    <td>
                        <button class="btn btn-sm btn-info"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>#PES003</td>
                    <td>Ahmad Wijaya</td>
                    <td>Nissan Livina</td>
                    <td>01 Jan 2026</td>
                    <td>05 Jan 2026</td>
                    <td><span class="badge bg-secondary">Selesai</span></td>
                    <td>Rp 1.600.000</td>
                    <td>
                        <button class="btn btn-sm btn-info"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
