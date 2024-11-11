<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Schedule Page">
    <x-navbars.sidebar activePage='pengajuan-bimbingan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Pengajuan Bimbingan"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12 col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header">
                            <h3 class="card-title text-center h3 mb-0">Pengajuan Bimbingan</h3>
                        </div>
                        <div class="card-body py-5">
                            @if ($appointments->isEmpty())
                                <p class="card-text text-center">Tidak ada pengajuan bimbingan</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nama Mahasiswa</th>
                                                <th scope="col">Tanggal Bimbingan</th>
                                                <th scope="col">Waktu Mulai</th>
                                                <th scope="col">Waktu Selesai</th>
                                                <th scope="col">Lokasi</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($appointments as $appointment)
                                                <tr>
                                                    <td>{{ $appointment->mahasiswa->user->name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($appointment->schedule->schedule_date)->format('d-m-Y') }}
                                                    </td>
                                                    <td>{{ $appointment->schedule->start_time }}</td>
                                                    <td>{{ $appointment->schedule->end_time }}</td>
                                                    <td>{{ $appointment->schedule->location ?? 'Belum ditentukan' }}
                                                    </td>
                                                    <td>
                                                        <!-- Form untuk menerima pengajuan -->
                                                        <form action="{{ route('appointments.update', $appointment) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="approved">
                                                            <input type="hidden" name="mahasiswa_id"
                                                                value="{{ $appointment->mahasiswa->id }}">
                                                            <input type="hidden" name="schedule_id"
                                                                value="{{ $appointment->schedule->id }}">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm">Terima</button>
                                                        </form>
                                                        <!-- Tombol untuk membuka modal tolak -->
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#rejectModal{{ $appointment->id }}">
                                                            Tolak
                                                        </button>

                                                        <!-- Modal Tolak -->
                                                        <div class="modal fade" id="rejectModal{{ $appointment->id }}"
                                                            tabindex="-1" aria-labelledby="rejectModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="rejectModalLabel">
                                                                            Alasan Penolakan</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form
                                                                            action="{{ route('appointments.update', $appointment) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="status"
                                                                                value="rejected">

                                                                            <div class="mb-3">
                                                                                <label for="reason"
                                                                                    class="form-label">Alasan
                                                                                    Penolakan</label>
                                                                                <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
                                                                            </div>

                                                                            <input type="hidden" name="mahasiswa_id"
                                                                                value="{{ $appointment->mahasiswa->id }}">
                                                                            <input type="hidden" name="schedule_id"
                                                                                value="{{ $appointment->schedule->id }}">
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Tutup</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-danger">Kirim
                                                                                    Alasan</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
