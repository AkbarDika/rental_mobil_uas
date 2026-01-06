@extends('layouts.admin')

@section('content')

<div class="page-title">
    <i class="bi bi-credit-card"></i>
    <h2 style="margin: 0;">Kelola Pembayaran</h2>
</div>

<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h5 style="margin: 0; font-weight: bold;">Daftar Pembayaran</h5>
        <button class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Tambah Pembayaran
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead style="background-color: #f5f7fa;">
                <tr>
                    <th>ID Pembayaran</th>
                    <th>ID Pemesanan</th>
                    <th>Pelanggan</th>
                    <th>Nominal</th>
                    <th>Metode</th>
                    <th>Tanggal Bayar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#PAY001</td>
                    <td>#PES001</td>
                    <td>Budi Santoso</td>
                    <td>Rp 1.500.000</td>
                    <td>Transfer Bank</td>
                    <td>06 Jan 2026</td>
                    <td><span class="badge bg-success">Terbayar</span></td>
                    <td>
                        <button class="btn btn-sm btn-info"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>#PAY002</td>
                    <td>#PES002</td>
                    <td>Siti Nurhaliza</td>
                    <td>Rp 1.350.000</td>
                    <td>Kartu Kredit</td>
                    <td>07 Jan 2026</td>
                    <td><span class="badge bg-warning">Menunggu Konfirmasi</span></td>
                    <td>
                        <button class="btn btn-sm btn-info"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>#PAY003</td>
                    <td>#PES003</td>
                    <td>Ahmad Wijaya</td>
                    <td>Rp 1.600.000</td>
                    <td>E-Wallet</td>
                    <td>01 Jan 2026</td>
                    <td><span class="badge bg-success">Terbayar</span></td>
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
