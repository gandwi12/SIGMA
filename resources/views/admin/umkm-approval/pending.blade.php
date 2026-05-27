@extends('layouts.app')

@section('title', 'Approval UMKM - Admin')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">📋 Approval Pendaftaran UMKM</h2>

    @if($umkms->isEmpty())
        <div class="alert alert-info">
            Tidak ada UMKM yang menunggu approval.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama UMKM</th>
                        <th>Pemilik</th>
                        <th>Email</th>
                        <th>Kategori</th>
                        <th>WhatsApp</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($umkms as $index => $umkm)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $umkm->nama_usaha }}</strong></td>
                        <td>{{ $umkm->pemilik ?? '-' }}</td>
                        <td>{{ $umkm->email }}</td>
                        <td>{{ $umkm->kategori }}</td>
                        <td>
                            <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $umkm->whatsapp) }}" 
                               target="_blank" class="btn btn-sm btn-success">
                                📱 Chat
                            </a>
                        </td>
                        <td>{{ $umkm->created_at->format('d M Y') }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary" 
                                    data-bs-toggle="modal" data-bs-target="#detailModal{{ $umkm->id }}">
                                👁️ Lihat
                            </button>

                            <form action="{{ route('admin.umkm.approve', $umkm) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success" 
                                        onclick="return confirm('Approve UMKM ini?')">
                                    ✅ Approve
                                </button>
                            </form>

                            <button type="button" class="btn btn-sm btn-danger" 
                                    data-bs-toggle="modal" data-bs-target="#rejectModal{{ $umkm->id }}">
                                ❌ Tolak
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Detail -->
                    <div class="modal fade" id="detailModal{{ $umkm->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail {{ $umkm->nama_usaha }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Pemilik:</strong> {{ $umkm->pemilik }}</p>
                                    <p><strong>Email:</strong> {{ $umkm->email }}</p>
                                    <p><strong>WhatsApp:</strong> {{ $umkm->whatsapp }}</p>
                                    <p><strong>Kategori:</strong> {{ $umkm->kategori }}</p>
                                    <p><strong>Lokasi:</strong> {{ $umkm->lokasi }}</p>
                                    <p><strong>Alamat:</strong> {{ $umkm->alamat }}</p>
                                    <p><strong>Jam Operasional:</strong> {{ $umkm->jam_operasional }}</p>
                                    <p><strong>Deskripsi:</strong></p>
                                    <p>{{ $umkm->deskripsi }}</p>
                                    @if($umkm->foto)
                                        <p><strong>Foto:</strong></p>
                                        <img src="{{ asset('storage/' . $umkm->foto) }}" class="img-fluid" style="max-width: 300px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Reject -->
                    <div class="modal fade" id="rejectModal{{ $umkm->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tolak {{ $umkm->nama_usaha }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.umkm.reject', $umkm) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Alasan Penolakan *</label>
                                            <textarea name="alasan" class="form-control" rows="4" 
                                                      placeholder="Jelaskan alasan penolakan..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Batal
                                        </button>
                                        <button type="submit" class="btn btn-danger">
                                            Tolak UMKM
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection