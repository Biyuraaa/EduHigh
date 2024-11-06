<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Super Vision Page">
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
                            @if (Auth::user()->mahasiswa->)
                                
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
