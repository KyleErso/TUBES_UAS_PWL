@extends('committee.commitNavigation')

@section('title', 'Panitia Dashboard')
@section('nav-color', 'bg-success')
@section('dashboard-name', 'Panitia Dashboard')

@section('content')
<div class="container my-4">
    <h3>Daftar Event</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(!empty($events) && count($events))
        <div class="table-responsive">
            <table class="table table-bordered mt-3">
                <thead class="table-light">
                    <tr>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Peserta</th>
                        {{-- <th>Aksi</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td>{{ $event['judul'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($event['tanggal'])->format('d/m/Y') }}</td>
                            <td>{{ $event['lokasi'] }}</td>
                            <td>
                                @if(!empty($event['pendaftar']))
                                    <ul class="mb-0">
                                        @foreach($event['pendaftar'] as $participant)
                                            <li class="mb-2">
                                                {{ $participant['nama'] ?? '-' }} ({{ $participant['email'] ?? '-' }})
                                                @if(isset($participant['hadir']) && $participant['hadir'] == true)
                                                    @if(empty($participant['sertifikat']))
                                                        {{-- Form upload sertifikat --}}
                                                        <form action="{{ route('committee.event.uploadCertificate') }}" method="POST" enctype="multipart/form-data" class="d-inline ms-2">
                                                            @csrf
                                                            <input type="hidden" name="eventId" value="{{ $event['_id'] }}">
                                                            <input type="hidden" name="participantId" value="{{ $participant['_id'] }}">
                                                            <input type="file" name="certificate" class="form-control form-control-sm d-inline" accept="image/*,application/pdf" style="width:220px;display:inline-block;" required>
                                                            <button type="submit" class="btn btn-sm btn-primary">
                                                                Upload Sertifikat
                                                            </button>
                                                        </form>
                                                    @else
                                                        <a href="{{ $participant['sertifikat'] }}" target="_blank" class="btn btn-sm btn-success ms-2">
                                                            Lihat Sertifikat
                                                        </a>
                                                    @endif
                                                @else
                                                    <span class="badge bg-warning text-dark ms-2">Belum absen</span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">Belum ada peserta</span>
                                @endif
                            </td>
                            {{-- <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#eventDetailModal" data-event='@json($event)'>
                                    Detail
                                </button>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-muted mt-3">Belum ada event ditemukan.</p>
    @endif
</div>
@endsection
