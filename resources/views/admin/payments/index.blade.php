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
                    
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
