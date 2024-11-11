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
                            <h3 class="card-title text-center h3 mb-0">Informasi Mahasiswa</h3>
                        </div>
                        <div class="card-body py-3">
                            <!-- Informasi Diri Mahasiswa -->
                            <h4>Informasi Diri</h4>
                            <p><strong>Nama:</strong> {{ $mahasiswa->user->name }}</p>
                            <p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
                            <p><strong>Email:</strong> {{ $mahasiswa->user->email }}</p>

                            <!-- Informasi Proposal -->
                            <h4>Informasi Proposal</h4>
                            @if ($mahasiswa->user->proposal)
                                <p><strong>Topik:</strong> {{ $mahasiswa->user->proposal->topic }}</p>
                                <p><strong>Background:</strong> {{ $mahasiswa->user->proposal->background }}</p>
                                <p><strong>KBK:</strong> {{ $mahasiswa->user->proposal->subkbk->kbk->name }}</p>
                                <p><strong>Sub-KBK:</strong> {{ $mahasiswa->user->proposal->subkbk->name }}</p>

                                <!-- Titles -->
                                <h5>Judul Proposal</h5>
                                <ul>
                                    @foreach ($mahasiswa->user->proposal->titles as $title)
                                        <li>{{ $title->name }}</li>
                                    @endforeach
                                </ul>

                                <!-- Research Questions -->
                                <h5>Pertanyaan Penelitian</h5>
                                <ul>
                                    @foreach ($mahasiswa->user->proposal->researchQuestions as $question)
                                        <li>{{ $question->question }}
                                            <ul>
                                                @foreach ($question->reasons as $reason)
                                                    <li><strong>Alasan:</strong> {{ $reason->reason }}</li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>

                                <!-- Previous Researches -->
                                <h5>Penelitian Sebelumnya</h5>
                                <ul>
                                    @foreach ($mahasiswa->user->proposal->previousResearches as $research)
                                        <li>
                                            <p><strong>Judul:</strong> {{ $research->title }}</p>
                                            <p><strong>Penulis:</strong> {{ $research->authors }}</p>
                                            <p><strong>DOI:</strong> {{ $research->doi }}</p>
                                            <p><strong>Pernyataan Masalah:</strong> {{ $research->problem_statement }}
                                            </p>
                                            <p><strong>Hasil:</strong> {{ $research->results }}</p>
                                        </li>
                                    @endforeach
                                </ul>

                                <!-- Outputs -->
                                <h5>Output Penelitian</h5>
                                <ul>
                                    @foreach ($mahasiswa->user->proposal->outputs as $output)
                                        <li>{{ $output->research_output }}</li>
                                    @endforeach
                                </ul>

                                <!-- Background Reasons -->
                                <h5>Alasan Latar Belakang</h5>
                                <ul>
                                    @foreach ($mahasiswa->user->proposal->backgroundReasons as $reason)
                                        <li>{{ $reason->reason }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>Mahasiswa ini belum memiliki proposal yang terdaftar.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
