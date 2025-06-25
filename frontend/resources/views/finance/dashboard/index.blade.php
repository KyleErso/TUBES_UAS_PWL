@extends('finance.financeNavigation')

@section('title', 'Finance Dashboard')
@section('nav-color', 'bg-success')
@section('dashboard-name', 'Finance Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h4>Financial Overview</h4>
            </div>
            <div class="card-body">
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5>Total Transactions</h5>
                                <p class="h2">{{ $stats['totalPaidParticipants'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Tambahkan statistik lain jika perlu -->
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Daftar Pembayaran User</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nama User</th>
                            <th>Event</th>
                            <th>Kode Pembayaran</th>
                            <th>Status</th>
                            <th>Bukti Bayar</th>
                            <th>Kode Absensi</th> {{-- Tambahkan kolom ini --}}
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment['user']['nama'] ?? '-' }}</td>
                            <td>{{ $payment['event']['judul'] ?? '-' }}</td>
                            <td>{{ $payment['kodePembayaran'] }}</td>
                            <td>
                                @if($payment['status'] === 'paid')
                                    <span class="badge bg-success">Paid</span>
                                @elseif($payment['status'] === 'waiting_approval')
                                    <span class="badge bg-warning text-dark">Menunggu ACC</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($payment['status']) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($payment['buktiBayar'])
                                    <a href="{{ $payment['buktiBayar'] }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                @else
                                    <span class="text-danger">Belum Upload</span>
                                @endif
                            </td>
                            <td>
                                @if(!empty($payment['kodeAbsensi']))
                                    <span class="badge bg-primary">{{ $payment['kodeAbsensi'] }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($payment['status'] === 'waiting_approval' && $payment['buktiBayar'])
                                    <form method="POST" action="{{ route('finance.updatePaymentStatus') }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="kodePembayaran" value="{{ $payment['kodePembayaran'] }}">
                                        <input type="hidden" name="paymentStatus" value="paid">
                                        <button type="submit" class="btn btn-success btn-sm">ACC</button>
                                    </form>
                                @elseif($payment['status'] === 'paid')
                                    <span class="text-success">Sudah ACC</span>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada pembayaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection