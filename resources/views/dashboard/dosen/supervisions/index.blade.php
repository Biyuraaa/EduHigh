<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Super Vision Page">
    <x-navbars.sidebar activePage='mahasiswa-bimbingan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Bimbingan Mahasiswa"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12 col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title text-center h3 mb-0">Mahasiswa</h3>
                        </div>
                        <div class="card-body py-5">
                            @if ($students->isEmpty())
                                <p class="card-text">Tidak ada mahasiswa yang sedang dibimbing</p>
                            @else
                                @foreach ($students as $student)
                                    <div class="card mt-3">
                                        <div class="card-body">
                                            <a href="{{ route('supervisions.showMahasiswa', $student) }}">
                                                <h5 class="card-title">{{ $student->user->name }}</h5>
                                            </a>
                                            <p class="card-text">NIM: {{ $student->nim }}</p>
                                            <p class="card-text">Email: {{ $student->user->email }}</p>
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
