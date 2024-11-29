<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Supervision Requests">
    <x-navbars.sidebar activePage='pengajuan-mahasiswa'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Pengajuan Mahasiswa"></x-navbars.navs.auth>

        <div class="container-fluid py-4">

            <div class="card shadow-lg">
                <!-- Card Header -->
                <div class="card-header bg-gradient-primary p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-white mb-0">
                                <i class="fas fa-user-clock me-2"></i>Pengajuan Mahasiswa
                            </h4>
                            <p class="text-white text-sm mb-0 opacity-8">
                                Kelola dan tindak lanjuti pengajuan bimbingan mahasiswa Anda
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if ($students->isEmpty())
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum Ada Pengajuan</h5>
                                <p class="text-sm text-muted">Belum ada mahasiswa yang mengajukan bimbingan</p>
                            </div>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach ($students as $student)
                                <div class="list-group-item student-item p-4">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar avatar-xl bg-gradient-primary rounded-circle">
                                                {{ strtoupper(substr($student->mahasiswa->user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="col ml-n2">
                                            <h5 class="mb-1">
                                                <a href="{{ route('supervisions.showMahasiswa', $student->mahasiswa) }}"
                                                    class="text-dark text-decoration-none">
                                                    {{ $student->mahasiswa->user->name }}
                                                </a>
                                            </h5>
                                            <p class="text-sm text-muted mb-0">
                                                <i class="fas fa-id-card me-2"></i>{{ $student->mahasiswa->nim }}
                                            </p>
                                            <p class="text-sm text-muted mb-0">
                                                <i
                                                    class="fas fa-envelope me-2"></i>{{ $student->mahasiswa->user->email }}
                                            </p>
                                        </div>
                                        <div class="col-auto">
                                            <div class="d-flex gap-2">
                                                <form action="{{ route('supervisions.approve', $student->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" value="{{ $student->id }}"
                                                        name="supervision_id">
                                                    <button type="submit" class="btn btn-success btn-sm px-3">
                                                        <i class="fas fa-check me-2"></i>Terima
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-danger btn-sm px-3"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal-{{ $student->id }}">
                                                    <i class="fas fa-times me-2"></i>Tolak
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Improved Modal -->
                                <div class="modal fade" id="rejectModal-{{ $student->id }}" tabindex="-1"
                                    aria-labelledby="rejectModalLabel-{{ $student->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="rejectModalLabel-{{ $student->id }}">Tolak
                                                    Pengajuan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('supervisions.reject', $student->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="comment-{{ $student->id }}">Pesan
                                                            Penolakan</label>
                                                        <textarea name="comment" id="comment-{{ $student->id }}" class="form-control" rows="4"
                                                            placeholder="Berikan alasan penolakan..." required></textarea>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="supervision_id"
                                                    value="{{ $student->id }}">
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
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Optional JavaScript for search functionality -->
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const studentItems = document.querySelectorAll('.student-item');

                searchInput.addEventListener('keyup', function() {
                    const filter = searchInput.value.toLowerCase();
                    studentItems.forEach(function(item) {
                        const name = item.querySelector('h5').textContent.toLowerCase();
                        if (name.includes(filter)) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        </script>
    @endpush
</x-layout>
