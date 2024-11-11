<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Super Vision Page">
    <x-navbars.sidebar activePage='dosen-pembimbing'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Dosen Pembimbing"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12 col-md-6">
                    <a href="{{ route('supervisions.index') }}" class="btn btn-primary">Kembali</a>
                    <div class="card shadow-lg">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title text-center h3 mb-0">{{ $dosen->user->name }}</h3>
                        </div>
                        <div class="card-body py-3">
                            <p class="card-text">NIDN: {{ $dosen->nidn }}</p>
                            <p class="card-text">Email: {{ $dosen->user->email }}</p>
                            <p class="card-text">No. Telp: {{ $dosen->user->phone }}</p>
                            <p class="card-text">Alamat: {{ $dosen->user->address }}</p>
                            <p class="card-text">Bidang Keahlian: {{ $dosen->kbk->name }}</p>
                            <p class="card-text">Jumlah Mahasiswa Bimbingan: {{ $dosen->superVisions->count() }}</p>
                            <p class="card-text">Jumlah Mahasiswa Bimbingan Sedang Bimbingan:
                                {{ $dosen->superVisions->where('status', 'approved')->count() }}</p>
                            <p class="card-text">Jumlah Mahasiswa Bimbingan Lulus:
                                {{ $dosen->superVisions->where('status', 'completed')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
