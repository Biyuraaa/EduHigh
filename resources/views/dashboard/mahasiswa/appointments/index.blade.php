<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Schedule Page">
    <x-navbars.sidebar activePage='jadwal-bimbingan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Pengajuan Bimbingan"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12 col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header">
                            <h3 class="card-title h3 mb-0">Jadwal Bimbingan</h3>
                        </div>
                        <div class="card-body py-5">
                            @if (Auth::user()->mahasiswa->superVisions->isEmpty())
                                <p class="card-text text-center">Anda belum memiliki dosen pembimbing</p>
                            @else
                                @if ($appointments->isEmpty())
                                    <p class="card-text text-center">Anda belum mengajukan bimbingan</p>
                                @else
                                    <div class="table-responsive">
                                        <table class="table text-center">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Tanggal</th>
                                                    <th scope="col">Waktu Mulai</th>
                                                    <th scope="col">Waktu Selesai</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Lokasi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($appointments as $appointment)
                                                    @if ($appointment->status == 'approved')
                                                        <tr>
                                                            <td>{{ \Carbon\Carbon::parse($appointment->schedule->schedule_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td>{{ $appointment->schedule->start_time }}</td>
                                                            <td>{{ $appointment->schedule->end_time }}</td>
                                                            <td>{{ ucfirst($appointment->status) }}</td>
                                                            <td>{{ $appointment->schedule->location ?? 'Belum ditentukan' }}
                                                            </td>
                                                        </tr>
                                                    @endif
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
