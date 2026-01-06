@extends('layouts.admin')

@section('content')

<div class="page-title">
    <i class="bi bi-car-front"></i>
    <h2 style="margin: 0;">Kelola Mobil</h2>
</div>

<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h5 style="margin: 0; font-weight: bold;">Daftar Mobil</h5>
        <button class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Tambah Mobil
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead style="background-color: #f5f7fa;">
                <tr>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Merk & Model</th>
                    <th>Kategori</th>
                    <th>Tahun</th>
                    <th>Harga/Hari</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#1</td>
                    <td><img src="https://via.placeholder.com/50" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;"></td>
                    <td>Honda Jazz</td>
                    <td><span class="badge bg-info">Hatchback</span></td>
                    <td>2023</td>
                    <td>Rp 500.000</td>
                    <td><span class="badge bg-success">Tersedia</span></td>
                    <td>
                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>#2</td>
                    <td><img src="https://via.placeholder.com/50" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;"></td>
                    <td>Toyota Avanza</td>
                    <td><span class="badge bg-warning">MPV</span></td>
                    <td>2022</td>
                    <td>Rp 450.000</td>
                    <td><span class="badge bg-success">Tersedia</span></td>
                    <td>
                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>#3</td>
                    <td><img src="https://via.placeholder.com/50" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;"></td>
                    <td>Nissan Livina</td>
                    <td><span class="badge bg-warning">MPV</span></td>
                    <td>2021</td>
                    <td>Rp 400.000</td>
                    <td><span class="badge bg-danger">Disewa</span></td>
                    <td>
                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
