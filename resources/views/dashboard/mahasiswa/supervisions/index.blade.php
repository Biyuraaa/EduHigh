<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Supervision Page">
    <x-navbars.sidebar activePage='dosen-pembimbing'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Dosen Pembimbing"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12 col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title text-center h3 mb-0">Dosen Pembimbing</h3>
                        </div>
                        <div class="card-body py-5">
                            @if (Auth::user()->proposal)
                                @php
                                    $approvedSupervision = Auth::user()->mahasiswa->superVisions->where(
                                        'status',
                                        'approved',
                                    );
                                @endphp

                                @if ($approvedSupervision->count() > 0)
                                    <!-- Display approved supervisor information -->
                                    @foreach ($approvedSupervision as $superVision)
                                        <div class="card mt-3">
                                            <div class="card-body">
                                                <a href="{{ route('supervisions.showDosen', $superVision->dosen) }}">
                                                    <h5 class="card-title">Dosen Pembimbing:
                                                        {{ $superVision->dosen->user->name }}</h5>
                                                </a>
                                                <p class="card-text">Status:
                                                    {{ $superVision->dosen_pembimbing == 'pembimbing_1' ? 'Dosen Pembimbing 1' : 'Dosen Pembimbing 2' }}
                                                </p>
                                                <p class="card-text">NIDN: {{ $superVision->dosen->nidn }}</p>
                                                <p class="card-text">Email:
                                                    {{ $superVision->dosen->user->email }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <!-- Display list of available supervisors to request supervision -->
                                    @foreach ($dosens as $dosen)
                                        <div class="card mt-3">
                                            <div class="card-body">
                                                <a href="{{ route('supervisions.showDosen', $dosen) }}">
                                                    <h5 class="card-title">{{ $dosen->user->name }}</h5>
                                                </a>
                                                <p class="card-text">NIDN: {{ $dosen->nidn }}</p>
                                                <p class="card-text">Email: {{ $dosen->user->email }}</p>

                                                @php
                                                    // Check if there is an existing supervision request for this dosen
                                                    $existingSupervision = Auth::user()
                                                        ->mahasiswa->superVisions->where('dosen_id', $dosen->id)
                                                        ->first();
                                                @endphp

                                                <form action="{{ route('supervisions.store') }}" method="POST"
                                                    id="ajukanForm-{{ $dosen->id }}">
                                                    @csrf
                                                    <input type="hidden" name="mahasiswa_id"
                                                        value="{{ Auth::user()->mahasiswa->id }}">
                                                    <input type="hidden" name="dosen_id" value="{{ $dosen->id }}">

                                                    <button type="submit" class="btn btn-primary"
                                                        {{ $existingSupervision && $existingSupervision->status == 'pending' ? 'disabled' : '' }}>
                                                        Ajukan
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @else
                                <p class="card-text">Anda belum mengajukan proposal</p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
