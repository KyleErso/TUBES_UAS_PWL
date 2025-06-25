{{-- filepath: /Users/mac/Desktop/event-app/frontend/resources/views/committee/dashboard/create.blade.php --}}
@extends('committee.commitNavigation')

@section('title', 'Buat Event Baru')
@section('dashboard-name', 'Buat Event Baru')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- Card Form Buat Event --}}
            <div class="card shadow-sm mb-4 border-0" style="background: #e9fbe7;">
                <div class="card-header bg-success text-white fw-bold border-0" style="background: #43b36a !important;">
                    Formulir Pembuatan Event
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('committee.event.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Event</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="waktu" class="form-label">Waktu Mulai</label>
                                <input type="time" class="form-control @error('waktu') is-invalid @enderror" id="waktu" name="waktu" value="{{ old('waktu') }}" required>
                                @error('waktu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="lokasi" class="form-label">Lokasi</label>
                                <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required>
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kapasitas" class="form-label">Kapasitas Peserta</label>
                                <input type="number" class="form-control @error('kapasitas') is-invalid @enderror" id="kapasitas" name="kapasitas" value="{{ old('kapasitas') }}" min="1" required>
                                @error('kapasitas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="biaya" class="form-label">Biaya Pendaftaran (Rp)</label>
                                <input type="number" class="form-control @error('biaya') is-invalid @enderror" id="biaya" name="biaya" value="{{ old('biaya') }}" min="0" required>
                                @error('biaya')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="poster" class="form-label">Poster Event (opsional)</label>
                                <input type="file" class="form-control @error('poster') is-invalid @enderror" id="poster" name="poster" accept="image/*">
                                @error('poster')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="durasi" class="form-label">Durasi (hari)</label>
                            <input type="number" class="form-control @error('durasi') is-invalid @enderror" id="durasi" name="durasi" value="{{ old('durasi') }}" min="1" required>
                            @error('durasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success fw-bold">Buat Event</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Card List Event --}}
            <div class="card shadow-sm">
                <div class="card-header bg-light fw-bold">
                    Daftar Event Anda
                </div>
                <div class="card-body">
                    @if(isset($events) && count($events))
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                        <th>Lokasi</th>
                                        <th>Kapasitas</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($events as $event)
                                        <tr>
                                            <td>{{ $event['judul'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($event['tanggal'])->format('d/m/Y') }}</td>
                                            <td>{{ $event['lokasi'] }}</td>
                                            <td>{{ $event['kapasitas'] }}</td>
                                            <td>
                                                @if($event['status'] === 'inactive')
                                                    <span class="badge bg-secondary">Nonaktif</span>
                                                @elseif($event['status'] === 'upcoming')
                                                    <span class="badge bg-info text-dark">Akan Datang</span>
                                                @else
                                                    <span class="badge bg-success">Aktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($event['status'] !== 'inactive')
                                                <form action="{{ route('committee.event.deactivate', ['id' => $event['_id']]) }}" method="POST" onsubmit="return confirm('Nonaktifkan event ini?')" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="Nonaktifkan Event">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </form>
                                                @endif
                                                {{-- Tombol Edit dan Hapus dihapus --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">Belum ada event yang Anda buat.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection