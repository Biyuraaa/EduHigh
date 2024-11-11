<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Super Vision Page">
    <x-navbars.sidebar activePage='pengajuan-mahasiswa'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Pengajuan Mahasiswa"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12 col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title text-center h3 mb-0">Pengajuan Mahasiswa</h3>
                        </div>
                        <div class="card-body py-5">
                            @if ($students->isEmpty())
                                <p class="card-text">Tidak ada pengajuan mahasiswa</p>
                            @else
                                @foreach ($students as $student)
                                    <div class="card mt-3">
                                        <div class="card-body">
                                            <a href="{{ route('supervisions.showMahasiswa', $student->mahasiswa) }}">
                                                <h5 class="card-title">{{ $student->mahasiswa->user->name }}</h5>
                                            </a>
                                            <p class="card-text">NIM: {{ $student->mahasiswa->nim }}</p>
                                            <p class="card-text">Email: {{ $student->mahasiswa->user->email }}</p>

                                            <div class="d-flex gap-2">
                                                <!-- Approve Button -->
                                                <form action="{{ route('supervisions.approve', $student->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="supervision_id"
                                                        value="{{ $student->id }}">

                                                    <button type="submit" class="btn btn-info">
                                                        Terima
                                                    </button>
                                                </form>

                                                <!-- Reject Button with Modal Trigger -->
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal-{{ $student->id }}">
                                                    Tolak
                                                </button>
                                            </div>

                                            <!-- Modal for Reject -->
                                            <div class="modal fade" id="rejectModal-{{ $student->id }}" tabindex="-1"
                                                aria-labelledby="rejectModalLabel-{{ $student->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="rejectModalLabel-{{ $student->id }}">Tolak
                                                                Pengajuan
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('supervisions.reject', $student->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="modal-body">
                                                                <input type="hidden" name="supervision_id"
                                                                    value="{{ $student->id }}">
                                                                <div class="form-group">
                                                                    <label for="comment">Pesan Penolakan</label>
                                                                    <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-danger">Tolak
                                                                    Pengajuan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
