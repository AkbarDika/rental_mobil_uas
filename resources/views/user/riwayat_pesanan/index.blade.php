@extends('layouts.app')

@section('content')

<div class="container-sm">

    <div class="page-title mb-3">
        <h4>Riwayat Pesanan Saya</h4>
    </div>
    
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Tanggal Pesan</th>
                    <th>Tgl Mulai</th>
                    <th>Tgl Selesai</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th width="120">Aksi</th>
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
                        <span class="badge bg-{{ 
                            $p->status == 'pending' ? 'warning' :
                            ($p->status == 'disetujui' ? 'success' : 'danger') }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-info btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#detail{{ $p->id }}">
                        Detail
                    </button>
                    
                    {{-- MODAL DETAIL --}}
                    <div class="modal fade" id="detail{{ $p->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5>Detail Pesanan #{{ $p->id }}</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Mobil</th>
                                                <th>Harga / Hari</th>
                                                <th>Jumlah Hari</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                @foreach ($p->details as $d)
                                                <tr>
                                                    <td>{{ $d->mobil->nama_mobil ?? '-' }}</td>
                                                    <td>Rp {{ number_format($d->harga) }}</td>
                                                    <td>{{ $d->jumlah_hari }} hari</td>
                                                    <td>Rp {{ number_format($d->subtotal) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            Belum ada pesanan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            {{-- PAGINATION --}}
            <div class="d-flex justify-content-center">
                {{ $pesanan->links() }}
            </div>
        </div>
    </div>
</div>
    
@endsection
    