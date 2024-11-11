<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Schedule Page">
    <x-navbars.sidebar activePage='pengajuan-bimbingan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Pengajuan Bimbingan"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12 col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header">
                            <h3 class="card-title h3 mb-0">Pengajuan Bimbingan</h3>
                        </div>
                        <div class="card-body py-5">
                            @if (Auth::user()->mahasiswa->superVisions->isEmpty())
                                <p class="card-text text-center">Anda belum memiliki dosen pembimbing</p>
                            @else
                                @if ($schedules->isEmpty())
                                    <p class="card-text text-center">Tidak ada jadwal bimbingan</p>
                                @else
                                    <div class="table-responsive">
                                        <table class="table text-center">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Tanggal</th>
                                                    <th scope="col">Waktu Mulai</th>
                                                    <th scope="col">Waktu Selesai</th>
                                                    <th scope="col">Lokasi</th>
                                                    <th scope="col">Kuota</th>
                                                    <th scope="col">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($schedules as $schedule)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($schedule->schedule_date)->format('d-m-Y') }}
                                                        </td>
                                                        <td>{{ $schedule->start_time }}</td>
                                                        <td>{{ $schedule->end_time }}</td>
                                                        <td>{{ $schedule->location ?? 'Belum ditentukan' }}</td>
                                                        <td>{{ $schedule->quota }}</td>
                                                        <td>
                                                            @php
                                                                // Cek apakah mahasiswa sudah memiliki appointment dengan status 'pending' atau 'approved' untuk jadwal ini
                                                                $hasActiveAppointment = $schedule->appointments
                                                                    ->where('mahasiswa_id', Auth::user()->mahasiswa->id)
                                                                    ->whereIn('status', ['pending', 'approved'])
                                                                    ->isNotEmpty();
                                                            @endphp
                                                            <form action="{{ route('appointments.store') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="schedule_id"
                                                                    value="{{ $schedule->id }}">
                                                                <input type="hidden" name="mahasiswa_id"
                                                                    value="{{ Auth::user()->mahasiswa->id }}">
                                                                <button type="submit" class="btn btn-primary"
                                                                    {{ $hasActiveAppointment ? 'disabled' : '' }}>
                                                                    <i class="fas fa-plus"></i>
                                                                    {{ $hasActiveAppointment ? 'Sudah Membuat Janji' : 'Buat Janji' }}
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
