<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Logbook Page">
    <x-navbars.sidebar activePage='log-book'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Logbook Konsultasi"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <!-- Card Header -->
                        <div class="card-header bg-gradient-primary p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="text-white mb-0">
                                        <i class="fas fa-book me-2"></i>Logbook Konsultasi
                                    </h4>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Riwayat konsultasi yang telah disetujui
                                    </p>
                                </div>
                                <div>
                                    <form action="{{ route('logbooks.export') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-light hover:shadow-lg transition-all duration-300">
                                            <i class="fas fa-print me-2"></i>
                                            <span>Cetak Logbook</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Table Content with Loading State -->
                        <div class="position-relative">
                            <div id="loadingOverlay"
                                class="position-absolute w-100 h-100 bg-white bg-opacity-80 d-none">
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                @if ($logbooks->isEmpty())
                                    <div class="text-center py-5">
                                        <div class="empty-state">
                                            <div class="empty-state-icon mb-4">
                                                <i class="fas fa-book-open fa-4x text-muted"></i>
                                            </div>
                                            <h5 class="text-muted">Belum Ada Logbook</h5>
                                            <p class="text-sm text-muted mb-0">
                                                Anda belum memiliki catatan konsultasi yang disetujui
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <table class="table align-items-center mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center ps-2">
                                                    No.</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    Tanggal</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center ps-2">
                                                    Dosen</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center ps-2">
                                                    Catatan</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center ps-2">
                                                    Komentar</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    Status</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center pe-2">
                                                    Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($logbooks as $index => $logbook)
                                                <tr>
                                                    <td class="text-center text-sm">{{ $loop->iteration }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="icon-shape icon-sm me-2 bg-gradient-primary shadow text-center">
                                                                <i
                                                                    class="fas fa-calendar-day text-white opacity-10"></i>
                                                            </div>
                                                            <span
                                                                class="text-sm">{{ \Carbon\Carbon::parse($logbook->appointment->schedule->schedule_date)->format('d M Y') }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="avatar avatar-sm bg-gradient-secondary rounded-circle me-2">
                                                                {{ strtoupper(substr($logbook->appointment->schedule->dosen->user->name, 0, 1)) }}
                                                            </div>
                                                            <span
                                                                class="text-sm">{{ $logbook->appointment->schedule->dosen->user->name }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="text-wrap" style="max-width: 200px;">
                                                        <p class="text-sm mb-0">{{ Str::limit($logbook->notes, 50) }}
                                                        </p>
                                                    </td>
                                                    <td class="text-wrap" style="max-width: 200px;">
                                                        <p class="text-sm mb-0">
                                                            {{ Str::limit($logbook->comments, 50) ?? 'Tidak ada komentar ' }}
                                                        </p>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-gradient-success">Disetujui</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm bg-gradient-info"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#logbookModal-{{ $logbook->id }}">
                                                            <i class="fas fa-eye me-1"></i>Detail
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <!-- Pagination -->
                                    <div class="border-top px-4 py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="text-sm text-muted mb-0">
                                                Showing {{ $logbooks->firstItem() }} to {{ $logbooks->lastItem() }} of
                                                {{ $logbooks->total() }} entries
                                            </p>
                                            {{ $logbooks->links() }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Improved Modal Design -->
        @foreach ($logbooks as $logbook)
            <div class="modal fade" id="logbookModal-{{ $logbook->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-primary">
                            <h5 class="modal-title text-white">
                                <i class="fas fa-book-reader me-2"></i>Detail Logbook
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="mb-4 pb-3 border-bottom">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar avatar-lg bg-gradient-primary rounded-circle me-3">
                                        {{ strtoupper(substr($logbook->appointment->schedule->dosen->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $logbook->appointment->schedule->dosen->user->name }}
                                        </h6>
                                        <p class="text-sm text-muted mb-0">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ \Carbon\Carbon::parse($logbook->appointment->schedule->schedule_date)->format('l, d F Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-uppercase text-muted mb-3">Catatan Konsultasi</h6>
                                <div class="bg-light rounded p-3">
                                    {{ $logbook->notes }}
                                </div>
                            </div>

                            <div>
                                <h6 class="text-uppercase text-muted mb-3">Komentar Dosen</h6>
                                <div class="bg-light rounded p-3">
                                    {{ $logbook->comments ?? 'Tidak ada komentar' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </main>
</x-layout>


@push('styles')
    <style>
        .empty-state-icon {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            background: #f8f9fa;
            border-radius: 50%;
        }

        .avatar {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .avatar-lg {
            width: 48px;
            height: 48px;
        }

        .icon-shape {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
        }

        @media print {

            .sidebar,
            .navbar,
            .card-header,
            .modal,
            .btn,
            .pagination {
                display: none !important;
            }

            .card {
                box-shadow: none !important;
            }

            .table {
                border: 1px solid #dee2e6;
            }

            .table td,
            .table th {
                border: 1px solid #dee2e6;
            }
        }
    </style>
@endpush
