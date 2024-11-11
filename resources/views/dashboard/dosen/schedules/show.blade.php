<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Schedule Page">
    <x-navbars.sidebar activePage='jadwal-bimbingan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Detail Jadwal Bimbingan"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12 col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title text-center h3 mb-0">Detail Jadwal Bimbingan</h3>
                            <a href="{{ route('schedules.index') }}" class="btn btn-primary">Back</a>
                        </div>
                        <div class="card-body py-5">
                            <h4>Informasi Jadwal Bimbingan</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ \Carbon\Carbon::parse($schedule->schedule_date)->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Waktu Mulai</th>
                                    <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Waktu Selesai</th>
                                    <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat</th>
                                    <td>{{ $schedule->location }}</td>
                                </tr>
                                <tr>
                                    <th>Kuota</th>
                                    <td>{{ $schedule->quota }}</td>
                                </tr>
                            </table>

                            <h4 class="mt-5">Daftar Mahasiswa</h4>
                            @if ($appointments->isEmpty())
                                <p class="card-text">Belum ada mahasiswa yang mendaftar.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nama Mahasiswa</th>
                                                <th>Judul Proposal</th>
                                                <th>Tanggal Pendaftaran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($appointments as $appointment)
                                                <tr>
                                                    <td>{{ $appointment->mahasiswa->user->name }}</td>
                                                    <td>{{ ucfirst($appointment->mahasiswa->user->proposal->titles->first()->name) }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($appointment->created_at)->format('d-m-Y H:i') }}
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
