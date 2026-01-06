@extends('layouts.admin')

@section('content')

<div class="page-title">
    <i class="bi bi-people"></i>
    <h2 style="margin: 0;">Kelola Pengguna</h2>
</div>

<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h5 style="margin: 0; font-weight: bold;">Daftar Pengguna</h5>
        <button class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Tambah Pengguna
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead style="background-color: #f5f7fa;">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Terdaftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#1</td>
                    <td>Admin User</td>
                    <td>admin@rentalmobil.com</td>
                    <td>admin</td>
                    <td><span class="badge bg-danger">Super Admin</span></td>
                    <td><span class="badge bg-success">Aktif</span></td>
                    <td>01 Jan 2026</td>
                    <td>
                        <button class="btn btn-sm btn-info"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>#2</td>
                    <td>Budi Santoso</td>
                    <td>budi@email.com</td>
                    <td>budi_santoso</td>
                    <td><span class="badge bg-info">Customer</span></td>
                    <td><span class="badge bg-success">Aktif</span></td>
                    <td>02 Jan 2026</td>
                    <td>
                        <button class="btn btn-sm btn-info"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>#3</td>
                    <td>Siti Nurhaliza</td>
                    <td>siti@email.com</td>
                    <td>siti_nur</td>
                    <td><span class="badge bg-info">Customer</span></td>
                    <td><span class="badge bg-success">Aktif</span></td>
                    <td>03 Jan 2026</td>
                    <td>
                        <button class="btn btn-sm btn-info"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>#4</td>
                    <td>Ahmad Wijaya</td>
                    <td>ahmad@email.com</td>
                    <td>ahmad_wijaya</td>
                    <td><span class="badge bg-secondary">Petugas</span></td>
                    <td><span class="badge bg-warning">Nonaktif</span></td>
                    <td>04 Jan 2026</td>
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
