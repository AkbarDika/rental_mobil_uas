@extends('layouts.petugas')

@section('content')

<div class="page-title">
    <i class="bi bi-arrow-return-left"></i>
    <h2 style="margin: 0;">Kelola Pengembalian</h2>
</div>

<div class="petugas-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Daftar Pengembalian</h5>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead style="background-color: #f5f7fa;">
                <tr>
                    <th>ID</th>
                    <th>Pemesanan ID</th>
                    <th>Nama Pelanggan</th>
                    <th>Tgl Kembali</th>
                    <th>Kondisi Mobil</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengembalian as $pg)
                <tr>
                    <td>{{ $pg->id_pengembalian }}</td>
                    <td>Pemesanan #{{ $pg->pemesanan_id }}</td>
                    <td>{{ $pg->pemesanan->user->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($pg->tanggal_kembali)->format('d M Y') }}</td>
                    <td>
                        @if($pg->kondisi_mobil == 'baik')
                            <span class="badge bg-success">Baik</span>
                        @else
                            <span class="badge bg-danger">Rusak</span>
                        @endif
                    </td>
                    <td>
                        @if($pg->status_pengembalian == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($pg->status_pengembalian == 'selesai')
                            <span class="badge bg-success">Selesai</span>
                        @else
                            <span class="badge bg-danger">Bermasalah</span>
                        @endif
                    </td>
                    <td>
                        <!-- DETAIL -->
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                            data-bs-target="#detail{{ $pg->id_pengembalian }}">
                            Detail
                        </button>

                        <!-- KONFIRMASI -->
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#konfirmasi{{ $pg->id_pengembalian }}">
                            Konfirmasi
                        </button>
                    </td>
                </tr>

                <!-- MODAL DETAIL -->
                <div class="modal fade" id="detail{{ $pg->id_pengembalian }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Pengembalian #{{ $pg->id_pengembalian }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <h6>Info Pengembalian:</h6>
                                <p><strong>ID Pengembalian:</strong> {{ $pg->id_pengembalian }}</p>
                                <p><strong>Pemesanan ID:</strong> #{{ $pg->pemesanan_id }}</p>
                                <p><strong>Tanggal Kembali:</strong> {{ $pg->tanggal_kembali }}</p>
                                <p><strong>Kondisi Mobil:</strong> {{ ucfirst($pg->kondisi_mobil) }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($pg->status_pengembalian) }}</p>
                                <p><strong>Catatan:</strong> {{ $pg->catatan ?? '-' }}</p>

                                <hr>

                                <h6>Info Pelanggan:</h6>
                                <p><strong>Nama:</strong> {{ $pg->pemesanan->user->name ?? '-' }}</p>
                                <p><strong>Email:</strong> {{ $pg->pemesanan->user->email ?? '-' }}</p>
                                <p><strong>No HP:</strong> {{ $pg->pemesanan->user->no_hp ?? '-' }}</p>

                                <hr>

                                <h6>Info Mobil:</h6>
                                @foreach ($pg->pemesanan->details as $d)
                                    <p><strong>Model:</strong> {{ $d->mobil->model ?? '-' }}</p>
                                    <p><strong>Nomor Plat:</strong> {{ $d->mobil->nomor_plat ?? '-' }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODAL KONFIRMASI -->
                <div class="modal fade" id="konfirmasi{{ $pg->id_pengembalian }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('petugas.pengembalian.konfirmasi', $pg->id_pengembalian) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Konfirmasi Pengembalian #{{ $pg->id_pengembalian }}</h5>
                                    <button type="button" class="btn-close"
                                        data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Status Pengembalian</label>
                                        <select name="status_pengembalian" class="form-control" required>
                                            <option value="pending" {{ $pg->status_pengembalian == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="selesai" {{ $pg->status_pengembalian == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="bermasalah" {{ $pg->status_pengembalian == 'bermasalah' ? 'selected' : '' }}>Bermasalah</option>
                                        </select>
                                    </div>

                                    <div class="alert alert-info">
                                        <small>
                                            <strong>Catatan:</strong><br>
                                            - Pending: Menunggu konfirmasi pengembalian<br>
                                            - Selesai: Mobil telah dikembalikan dengan baik<br>
                                            - Bermasalah: Ada masalah dengan pengembalian (mobil rusak, keterlambatan, dll)
                                        </small>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">Update Status</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="7" class="text-center">Data pengembalian belum tersedia</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $pengembalian->links() }}
    </div>
</div>

@endsection
