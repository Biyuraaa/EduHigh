<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Proposal Page">
    <x-navbars.sidebar activePage='proposals'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Proposal"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12 col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title text-center h3 mb-0">Form Usulan Topik Skripsi</h3>
                            @if (Auth::user()->proposal)
                                <a href="{{ route('proposals.edit', Auth::user()->proposal->id) }}"
                                    class="btn btn-warning">Perbarui Proposal</a>
                            @else
                                <a href="{{ route('proposals.create') }}" class="btn btn-primary">Buat Proposal</a>
                            @endif
                        </div>
                        <div class="card-body py-5">
                            <!-- Section I: Pengusul -->
                            @if (Auth::user()->proposal)
                                <p class="card-text mb-2"><strong>I. Pengusul :</strong></p>
                                <p>Nama: {{ Auth::user()->name }}</p>
                                <p>NIM: {{ Auth::user()->mahasiswa->nim }}</p>

                                <!-- Section II: Topik -->
                                <p class="card-text mt-4"><strong>II. Topik :</strong></p>
                                <p>Nama Topik: {{ $proposal->topic ?? 'Anda belum membuat topic' }}</p>
                                <p>KBK (pilih salah satu): {{ $proposal->subkbk->name ?? 'Anda belum membuat subkbk' }}
                                </p>

                                <!-- Section III: Usulan Judul Skripsi -->
                                <p class="card-text mt-4"><strong>III. Usulan Judul Skripsi :</strong></p>
                                @if ($proposal->titles->isEmpty())
                                    <p>Anda belum membuat judul skripsi</p>
                                @else
                                    <ul>
                                        @foreach ($proposal->titles as $title)
                                            <li>Alternatif {{ $loop->iteration }}: {{ $title->name }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                                <!-- Section IV: Latar Belakang Masalah -->
                                <p class="card-text mt-4"><strong>IV. Latar Belakang Masalah :</strong></p>
                                <p>a. Permasalahan yang akan diselesaikan:
                                    {{ $proposal->background ?? 'Anda belum membuat permasalahan yang akan diselesaikan' }}
                                </p>
                                <p>b. Alasan pemilihan masalah:</p>
                                @if ($proposal->backgroundReasons->isEmpty())
                                    <p>Anda belum membuat alasan pemilihan masalah</p>
                                @else
                                    <ul>
                                        @foreach ($proposal->backgroundReasons as $reason)
                                            <li>{{ $reason->reason }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                                <!-- Section V: Penelitian Sebelumnya -->
                                <p class="card-text mt-4"><strong>V. Penelitian Sebelumnya :</strong></p>
                                @if ($proposal->previousResearches->isEmpty())
                                    <p>Anda belum membuat penelitian sebelumnya</p>
                                @else
                                    @foreach ($proposal->previousResearches as $previousResearch)
                                        <p>Judul: {{ $previousResearch->title }}</p>
                                        <p>Penulis: {{ $previousResearch->authors }}</p>
                                        <p>DOI: {{ $previousResearch->doi }}</p>
                                        <p>Permasalahan yang diangkat: {{ $previousResearch->problem_statement }}</p>
                                        <p>Hasil penelitian: {{ $previousResearch->results }}</p>
                                    @endforeach
                                @endif

                                <!-- Section VI: Rumusan Masalah -->
                                <p class="card-text mt-4"><strong>VI. Rumusan Masalah :</strong></p>
                                @if ($proposal->researchQuestions->isEmpty())
                                    <p>Anda belum membuat rumusan masalah</p>
                                @else
                                    <ul>
                                        @foreach ($proposal->researchQuestions as $researchQuestion)
                                            <li>{{ $researchQuestion->question }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                                <!-- Section VII: Output Penelitian -->
                                <p class="card-text mt-4"><strong>VII. Output Penelitian :</strong></p>
                                @if ($proposal->outputs->isEmpty())
                                    <p>Anda belum membuat output penelitian</p>
                                @else
                                    <ul>
                                        @foreach ($proposal->outputs as $output)
                                            <li>{{ $output->research_output }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            @else
                                <p class="text-center">Anda belum membuat proposal</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
