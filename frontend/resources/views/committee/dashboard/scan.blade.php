@extends('committee.commitNavigation')
@section('title', 'Scan Absensi')
@section('dashboard-name', 'Scan Absensi')
@section('content')
<div class="container py-4">
    <h3 class="mb-4">Scan QR Absensi Peserta</h3>
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Scan QR Kamera --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div id="reader"></div>
                    <div id="result" class="mt-4"></div>
                </div>
            </div>

            {{-- Scan QR dari Upload Gambar --}}
            <div class="card mb-4">
                <div class="card-header">Scan QR dari Gambar</div>
                <div class="card-body">
                    <input type="file" id="qrImageInput" accept="image/*" class="form-control mb-2">
                    <div class="mb-2">
                        <img id="qrPreview" src="" alt="Preview QR" style="max-width: 300px; display: none;"/>
                    </div>
                    <button type="button" id="scanImageBtn" class="btn btn-outline-secondary mb-2" disabled>Scan Gambar</button>
                    <div id="qrResult" class="mt-2 text-success fw-bold"></div>
                    <form id="uploadForm" action="{{ route('committee.event.scanAttendance') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kodeAbsensi" id="kodeAbsensiImage">
                        <button type="submit" class="btn btn-primary" id="submitImage" disabled>Submit Absensi</button>
                    </form>
                </div>
            </div>

            {{-- Input Manual & Generate QR --}}
            <div class="card mb-4">
                <div class="card-header">Input Manual Kode Absensi & Generate QR</div>
                <div class="card-body">
                    <form id="manualForm" action="{{ route('committee.event.scanAttendance') }}" method="POST">
                        @csrf
                        <div class="input-group mb-2">
                            <input type="text"
                                   name="kodeAbsensi"
                                   id="kodeManual"
                                   class="form-control"
                                   placeholder="Masukkan kode absensi"
                                   required>
                            <button type="button"
                                    class="btn btn-outline-secondary"
                                    id="generateQRBtn">
                                Generate QR
                            </button>
                        </div>
                        <button type="submit" class="btn btn-secondary">Submit Absensi</button>
                    </form>
                    <div id="qrcode" class="mt-3"></div>
                </div>
            </div>

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger mt-2">{{ session('error') }}</div>
            @endif

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // === SCAN VIA KAMERA ===
    const scanner = new Html5QrcodeScanner('reader', {
        qrbox: { width: 250, height: 250 },
        fps: 20,
    });
    scanner.render(onScanSuccess, onScanError);

    function onScanSuccess(decodedText) {
        document.getElementById('result').innerHTML = `
            <h5 class="text-success">Absensi Berhasil!</h5>
            <div class="alert alert-success">
                Kode Absensi: <strong>${decodedText}</strong>
            </div>
            <form method="POST"
                  action="{{ route('committee.event.scanAttendance') }}"
                  onsubmit="return confirm('Yakin ingin melakukan absensi untuk kode ini?');">
                @csrf
                <input type="hidden" name="kodeAbsensi" value="${decodedText}">
                <button type="submit" class="btn btn-success mt-3">
                    Konfirmasi Absensi
                </button>
            </form>
        `;
        scanner.clear();
        document.getElementById('reader').remove();
    }

    function onScanError(error) {
        // Tidak perlu tampilkan error setiap frame
    }

    // === SCAN VIA UPLOAD GAMBAR ===
    const fileInput   = document.getElementById('qrImageInput');
    const previewImg  = document.getElementById('qrPreview');
    const scanBtn     = document.getElementById('scanImageBtn');
    const resultDiv   = document.getElementById('qrResult');
    const hiddenInput = document.getElementById('kodeAbsensiImage');
    const submitBtn   = document.getElementById('submitImage');

    fileInput.addEventListener('change', e => {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = () => {
            previewImg.src = reader.result;
            previewImg.style.display = 'block';
            resultDiv.textContent  = '';
            hiddenInput.value       = '';
            submitBtn.disabled      = true;
            scanBtn.disabled        = false;
        };
        reader.readAsDataURL(file);
    });

    scanBtn.addEventListener('click', () => {
        const canvas = document.createElement('canvas');
        canvas.width  = previewImg.naturalWidth;
        canvas.height = previewImg.naturalHeight;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(previewImg, 0, 0);

        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(imageData.data, canvas.width, canvas.height);

        if (code) {
            resultDiv.textContent    = 'Hasil QR: ' + code.data;
            hiddenInput.value        = code.data;
            submitBtn.disabled       = false;
        } else {
            alert('QR code tidak terdeteksi pada gambar.');
            resultDiv.textContent    = '';
            hiddenInput.value        = '';
            submitBtn.disabled       = true;
        }
        scanBtn.disabled = true;
    });

    // === GENERATE QR DARI INPUT MANUAL ===
    document.getElementById('generateQRBtn').addEventListener('click', () => {
        const kode = document.getElementById('kodeManual').value.trim();
        const qrDiv = document.getElementById('qrcode');
        qrDiv.innerHTML = '';
        if (kode) {
            new QRCode(qrDiv, {
                text: kode,
                width: 200,
                height: 200
            });
        }
    });
});
</script>
@endpush

@push('styles')
<style>
#reader {
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
}
#result {
    text-align: center;
    font-size: 1.1rem;
}
</style>
@endpush
