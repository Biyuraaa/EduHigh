<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Schedule Page">
    <x-navbars.sidebar activePage='jadwal-bimbingan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Jadwal Bimbingan"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12 col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header">
                            <h3 class="card-title text-center h3 mb-0">Jadwal Bimbingan</h3>
                            <a href="{{ route('schedules.create') }}" class="btn btn-primary">Buat Jadwal Baru</a>
                        </div>
                        <div class="card-body py-5">
                            @if ($schedules->isEmpty())
                                <p class="card-text">Tidak ada jadwal bimbingan</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                @if (Auth::user()->role == 'admin')
                                                    <th>Dosen</th>
                                                @endif
                                                <th>Tanggal</th>
                                                <th>Waktu Mulai</th>
                                                <th>Waktu Selesai</th>
                                                <th>Tempat</th>
                                                <th>Kuota</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($schedules as $schedule)
                                                <tr>
                                                    @if (Auth::user()->role == 'admin')
                                                        <td>{{ $schedule->dosen->user->name }}</td>
                                                    @endif
                                                    <td>{{ \Carbon\Carbon::parse($schedule->schedule_date)->format('d-m-Y') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                                    </td>
                                                    <td>{{ $schedule->location }}</td>
                                                    <td>{{ $schedule->quota }}</td>

                                                    <td>
                                                        <a href="{{ route('schedules.show', $schedule) }}"
                                                            class="btn btn-info btn-sm">Show</a>
                                                        <a href="{{ route('schedules.edit', $schedule) }}"
                                                            class="btn btn-warning btn-sm">Edit</a>
                                                        <form action="{{ route('schedules.destroy', $schedule->id) }}"
                                                            method="POST" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">Hapus</button>
                                                        </form>
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
