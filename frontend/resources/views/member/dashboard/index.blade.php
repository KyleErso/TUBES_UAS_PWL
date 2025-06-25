@extends('member.memberNavigation')

@section('title', 'Member Dashboard')
@section('nav-color', 'bg-warning')
@section('dashboard-name', 'Member Dashboard')

@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>My Events</h4>
            </div>
            <div class="card-body">
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card bg-warning text-dark">
                            <div class="card-body">
                                <h5>Registered Events</h5>
                                <p class="h2">{{ $data['registered_events'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Daftar Registrasi --}}
                <div class="row mt-5">
                    <div class="col-12">
                        <h5>Daftar Event yang Anda Ikuti</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Judul Event</th>
                                    <th>Tanggal</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Kode Pembayaran</th>
                                    <th>Kode Absensi</th>
                                    <th>QR Code</th>
                                    <th>Aksi</th> {{-- Tambahkan kolom aksi --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registrations as $reg)
                                    <tr>
                                        <td>{{ $reg['event']['judul'] ?? '-' }}</td>
                                        <td>
                                            @if(!empty($reg['event']['tanggal']))
                                                {{ \Carbon\Carbon::parse($reg['event']['tanggal'])->format('d M Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $reg['event']['lokasi'] ?? '-' }}</td>
                                        <td>
                                            @if($reg['status'] === 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif($reg['status'] === 'waiting_approval')
                                                <span class="badge bg-warning text-dark">Menunggu ACC</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($reg['status']) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $reg['kodePembayaran'] ?? '-' }}</td>
                                        <td>
                                            @if(!empty($reg['kodeAbsensi']))
                                                <span class="badge bg-primary">{{ $reg['kodeAbsensi'] }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($reg['kodeAbsensi']))
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#qrModal-{{ $reg['_id'] }}">
                                                    Lihat QR
                                                </button>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($reg['status'] === 'pending')
                                                <form action="{{ route('member.uploadBukti', ['id' => $reg['_id']]) }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2">
                                                    @csrf
                                                    <input type="file" name="buktiBayar" class="form-control form-control-sm" accept="image/*" required>
                                                    <button type="submit" class="btn btn-sm btn-primary">Kirim</button>
                                                </form>
                                                @if(!empty($reg['buktiBayar']))
                                                    <div class="mt-2">
                                                        <a href="{{ $reg['buktiBayar'] }}" target="_blank">
                                                            <img src="{{ $reg['buktiBayar'] }}" alt="Bukti Bayar" style="max-width: 100px; max-height: 100px;">
                                                        </a>
                                                    </div>
                                                @endif
                                            @elseif($reg['status'] === 'waiting_approval')
                                                <span class="badge bg-warning text-dark">Menunggu ACC</span>
                                                @if(!empty($reg['buktiBayar']))
                                                    <div class="mt-2">
                                                        <a href="{{ $reg['buktiBayar'] }}" target="_blank">
                                                            <img src="{{ $reg['buktiBayar'] }}" alt="Bukti Bayar" style="max-width: 100px; max-height: 100px;">
                                                        </a>
                                                    </div>
                                                @endif
                                            @elseif($reg['status'] === 'paid')
                                                <span class="badge bg-success">Paid</span>
                                                @if(!empty($reg['buktiBayar']))
                                                    <div class="mt-2">
                                                        <a href="{{ $reg['buktiBayar'] }}" target="_blank">
                                                            <img src="{{ $reg['buktiBayar'] }}" alt="Bukti Bayar" style="max-width: 100px; max-height: 100px;">
                                                        </a>
                                                    </div>
                                                @endif
                                                @if(!empty($reg['hadir']) && $reg['hadir'] === true && !empty($reg['sertifikat']))
                                                    <div class="mt-2">
                                                        <a href="{{ $reg['sertifikat'] }}" download class="btn btn-sm btn-success">
                                                            Download Sertifikat
                                                        </a>
                                                    </div>
                                                @elseif(!empty($reg['hadir']) && $reg['hadir'] === true)
                                                    <div class="mt-2">
                                                        <span class="badge bg-info text-dark">Absensi Terkonfirmasi</span>
                                                    </div>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($reg['status']) }}</span>
                                            @endif
                                        </td>
                                    </tr>

                                    {{-- Modal QR Code --}}
                                    @if(!empty($reg['kodeAbsensi']))
                                        <div class="modal fade" id="qrModal-{{ $reg['_id'] }}" tabindex="-1" aria-labelledby="qrModalLabel-{{ $reg['_id'] }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="qrModalLabel-{{ $reg['_id'] }}">QR Code Absensi</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        {{-- Generate SVG QR --}}
                                                        <div id="qr-svg-{{ $reg['_id'] }}">
                                                            {!! QrCode::format('svg')->size(200)->generate($reg['kodeAbsensi']) !!}
                                                        </div>
                                                        <div class="mt-3">
                                                            <strong>{{ $reg['kodeAbsensi'] }}</strong>
                                                        </div>
                                                        <button class="btn btn-success mt-3" onclick="downloadQrPng('{{ $reg['_id'] }}')">Download QR</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    {{-- End Modal QR Code --}}
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Belum ada registrasi event.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- End Daftar Registrasi --}}

                {{-- Status Absensi untuk Semua Event --}}
                <div class="row mt-5">
                    <div class="col-12">
                        <h5>Status Absensi Event Anda</h5>

                        {{-- Unpaid Section --}}
                        <h6 class="mt-4 mb-2 text-danger">Belum Lunas (Unpaid)</h6>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Judul Event</th>
                                    <th>Tanggal</th>
                                    <th>Status Pembayaran</th>
                                    <th>Status Absensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $hasUnpaid = false;
                                @endphp
                                @foreach($registrations as $reg)
                                    @if($reg['status'] !== 'paid')
                                        @php $hasUnpaid = true; @endphp
                                        <tr>
                                            <td>{{ $reg['event']['judul'] ?? '-' }}</td>
                                            <td>
                                                @if(!empty($reg['event']['tanggal']))
                                                    {{ \Carbon\Carbon::parse($reg['event']['tanggal'])->format('d M Y') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-danger">Unpaid</span>
                                            </td>
                                            <td>
                                                @if(!empty($reg['absensi']) && $reg['absensi'] === true)
                                                    <span class="badge bg-success">Hadir</span>
                                                @else
                                                    <span class="badge bg-secondary">Belum Hadir</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                @if(!$hasUnpaid)
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Tidak ada event unpaid.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        {{-- Paid Section --}}
                        <h6 class="mt-4 mb-2 text-success">Sudah Lunas (Paid)</h6>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Judul Event</th>
                                    <th>Tanggal</th>
                                    <th>Status Pembayaran</th>
                                    <th>Status Absensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $hasPaid = false;
                                @endphp
                                @foreach($registrations as $reg)
                                    @if($reg['status'] === 'paid')
                                        @php $hasPaid = true; @endphp
                                        <tr>
                                            <td>{{ $reg['event']['judul'] ?? '-' }}</td>
                                            <td>
                                                @if(!empty($reg['event']['tanggal']))
                                                    {{ \Carbon\Carbon::parse($reg['event']['tanggal'])->format('d M Y') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-success">Paid</span>
                                            </td>
                                            <td>
                                                @if(!empty($reg['hadir']) && $reg['hadir'] === true)
                                                    <span class="badge bg-success">Hadir</span>
                                                    @if(!empty($reg['sertifikat']))
                                                        <a href="{{ $reg['sertifikat'] }}" download class="btn btn-sm btn-success ms-2">
                                                            Download Sertifikat
                                                        </a>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">Belum Hadir</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                @if(!$hasPaid)
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Tidak ada event paid.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function downloadQrPng(id) {
    var svgElement = document.querySelector('#qr-svg-' + id + ' svg');
    if (!svgElement) return;

    // Serialize SVG
    var serializer = new XMLSerializer();
    var svgString = serializer.serializeToString(svgElement);

    // Create image
    var img = new Image();
    var svgBlob = new Blob([svgString], {type: "image/svg+xml;charset=utf-8"});
    var url = URL.createObjectURL(svgBlob);

    img.onload = function() {
        var canvas = document.createElement('canvas');
        canvas.width = img.width;
        canvas.height = img.height;
        var ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0);

        // Download as PNG
        var pngUrl = canvas.toDataURL("image/png");
        var a = document.createElement('a');
        a.href = pngUrl;
        a.download = 'qr-absensi-' + id + '.png';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    };
    img.src = url;
}
</script>
@endsection
