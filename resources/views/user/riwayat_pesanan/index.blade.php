@extends('layouts.app')

@section('content')

<style>
    .modal-backdrop.show {
        opacity: 0.2; /* default 0.5 */
    }
</style>

<div class="container-sm">

    <h4 class="mb-3">Riwayat Pesanan Saya</h4>

    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal Pesan</th>
                        <th>Tgl Mulai</th>
                        <th>Tgl Selesai</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pesanan as $p)
                    <tr>
                        <td>#{{ $p->id }}</td>
                        <td>{{ $p->tanggal_pesan }}</td>
                        <td>{{ $p->tanggal_mulai }}</td>
                        <td>{{ $p->tanggal_selesai }}</td>
                        <td>Rp {{ number_format($p->total_harga) }}</td>
                        <td>
                            <span class="badge bg-{{ $p->status_badge }}">
                                {{ $p->status_tampilan }}
                            </span>
                        </td>

                        <td>
                            <button class="btn btn-info btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#detail{{ $p->id }}">
                                Detail
                            </button>

                            @if (
                                $p->status_tampilan === 'Sedang Disewa' &&
                                !$p->pengembalian
                            )
                                <button class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#pengembalian{{ $p->id }}">
                                    Pengembalian
                                </button>
                            @endif
                        </td>
                    </tr>

                    <!-- MODAL PENGEMBALIAN -->
                    <div class="modal fade" id="pengembalian{{ $p->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <form action="{{ route('pengembalian.storeUser') }}" method="POST" class="modal-content">
                                    @csrf
                                    
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ajukan Pengembalian Mobil</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    
                                    <div class="modal-body">
                                        <!-- hidden pemesanan -->
                                        <input type="hidden" name="pemesanan_id" value="{{ $p->id }}">
                                        
                                        <!-- tanggal kembali -->
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Kembali</label>
                                            <input type="date"
                                            class="form-control"
                                            name="tanggal_kembali"
                                            value="{{ date('Y-m-d') }}"
                                            readonly>
                                        </div>
                                        
                                        <!-- kondisi mobil -->
                                        <div class="mb-3">
                                            <label class="form-label">Kondisi Mobil</label>
                                            <select name="kondisi_mobil" class="form-select" required>
                                                <option value="">-- Pilih Kondisi --</option>
                                                <option value="baik">Baik</option>
                                                <option value="lecet">Lecet</option>
                                                <option value="rusak">Rusak</option>
                                            </select>
                                        </div>
                                        
                                        <!-- catatan -->
                                        <div class="mb-3">
                                            <label class="form-label">Catatan (opsional)</label>
                                            <textarea name="catatan" class="form-control" rows="3"
                                            placeholder="Contoh: ada goresan kecil di bumper"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">
                                            Kirim Pengembalian
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- MODAL DETAIL -->
                    <div class="modal fade" id="detail{{ $p->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Pemesanan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <p><strong>Pelanggan:</strong> {{ $p->user->name }}</p>
                                    <p><strong>Tanggal Pesan:</strong> {{ $p->tanggal_pesan }}</p>
                                    <p><strong>Tanggal Mulai:</strong> {{ $p->tanggal_mulai }}</p>
                                    <p><strong>Tanggal Selesai:</strong> {{ $p->tanggal_selesai }}</p>
                                    <p><strong>Status:</strong> {{ ucfirst($p->status) }}</p>

                                    <hr>

                                    @foreach ($p->details as $d)
                                        <p><strong>Mobil:</strong> {{ $d->mobil->model ?? '-' }}</p>
                                        <p><strong>Nomor Plat:</strong> {{ $d->mobil->nomor_plat ?? '-' }}</p>
                                    @endforeach

                                    <hr>

                                    <p class="fw-bold">
                                        Total Harga: Rp {{ number_format($p->total_harga) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            Belum ada pesanan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $pesanan->links() }}

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection
