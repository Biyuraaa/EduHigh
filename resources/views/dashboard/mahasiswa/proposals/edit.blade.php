@php
    $titles = old('titles', $proposal->titles ?? []);
    $backgroundReasons = old('backgroundReasons', $proposal->backgroundReasons ?? []);
    $previousResearches = old('previousResearches', $proposal->previousResearches ?? []);
    $researchQuestions = old('researchQuestions', $proposal->researchQuestions ?? []);
    $outputs = old('outputs', $proposal->outputs ?? []);
@endphp




<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Edit Proposal Page">
    <x-navbars.sidebar activePage='proposals'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Edit Proposal"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-body py-5">
                            <a href="{{ route('proposals.index') }}" class="btn btn-primary">Back</a>
                            <h3 class="card-title text-center mb-4">Edit Usulan Topik Skripsi</h3>

                            <!-- Display validation errors -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Proposal Edit Form -->
                            <form action="{{ route('proposals.update', $proposal->id) }}" id="profileForm"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <h4>I. Pengusul</h4>
                                <!-- Nama Pengusul -->
                                <div class="mb-3 input-group input-group-outline">
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ Auth::user()->name }}" disabled>
                                </div>

                                <!-- NIM Pengusul -->
                                <div class="mb-3 input-group input-group-outline">
                                    <input type="text" name="nim" id="nim" class="form-control"
                                        value="{{ Auth::user()->mahasiswa->nim }}" disabled>
                                </div>

                                <h4>II. Topik</h4>
                                <!-- Nama Topik -->
                                <div class="mb-3 input-group input-group-outline">
                                    <label for="topic" class="form-label"></label>
                                    <input type="text" name="topic" id="topic" class="form-control"
                                        value="{{ old('topic', $proposal->topic) }}" required>
                                </div>

                                <!-- KBK Selection -->
                                <div class="mb-3 input-group input-group-outline">
                                    <label for="subkbk" class="form-label"></label>
                                    <select name="subkbk_id" id="subkbk" class="form-control" required>
                                        <option value="">KBK (Pilih Salah Satu)</option>
                                        @foreach ($subkbks as $subkbk)
                                            <option value="{{ $subkbk->id }}"
                                                {{ old('subkbk_id', $proposal->subkbk_id) == $subkbk->id ? 'selected' : '' }}>
                                                {{ $subkbk->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <h4>III. Usulan Judul Skripsi</h4>
                                <div class="mb-3">
                                    <label for="titles" class="form-label"></label>
                                    <div id="title-container"
                                        class="d-flex flex-column gap-2 input-group input-group-outline">
                                        @foreach (old('titles', $proposal->titles) as $index => $title)
                                            <div class="input-group mb-2">
                                                <input type="text" name="titles[]" class="form-control"
                                                    value="{{ $title->name }}" required>
                                                <button type="button" class="btn btn-outline-danger remove-input">
                                                    <i class="fa fa-trash "></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" id="add-title"
                                        class="btn btn-sm btn-outline-primary">+</button>
                                </div>

                                <h4>IV. Latar Belakang Masalah</h4>
                                <div class="mb-3 input-group input-group-outline">
                                    <label for="background" class="form-label"></label>
                                    <input type="text" name="background" id="background" class="form-control"
                                        value="{{ old('background', $proposal->background) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="backgroundReasons" class="form-label"></label>
                                    <div id="reason-container" class="d-flex flex-column gap-2">
                                        @foreach (old('backgroundReasons', $proposal->backgroundReasons) as $index => $reason)
                                            <div class="input-group mb-2 input-group-outline">
                                                <input type="text" name="backgroundReasons[]" class="form-control"
                                                    value="{{ $reason->reason }}" required>
                                                <button type="button" class="btn btn-outline-danger remove-input">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" id="add-reason"
                                        class="btn btn-sm btn-outline-primary">+</button>
                                </div>

                                <h4>V. Penelitian Sebelumnya</h4>
                                <div class="mb-3">
                                    <label for="previousResearches" class="form-label">Penelitian Sebelumnya</label>
                                    <div id="research-container" class="d-flex flex-column gap-2">
                                        @foreach (old('previousResearches', $proposal->previousResearches) as $index => $research)
                                            <div class="research-group mb-3 input-group">
                                                <div class="d-flex flex-column flex-grow-1 gap-2">
                                                    <div class="mb-3 input-group input-group-outline">
                                                        <label class="form-label"></label>
                                                        <input type="text"
                                                            name="previousResearches[{{ $index }}][title]"
                                                            class="form-control" value="{{ $research['title'] }}"
                                                            required>
                                                    </div>
                                                    <div class="mb-3 input-group input-group-outline">
                                                        <label class="form-label"></label>
                                                        <input type="text"
                                                            name="previousResearches[{{ $index }}][doi]"
                                                            class="form-control" value="{{ $research['doi'] }}"
                                                            required>
                                                    </div>
                                                    <div class="mb-3 input-group input-group-outline">
                                                        <label class="form-label"></label>
                                                        <input type="text"
                                                            name="previousResearches[{{ $index }}][authors]"
                                                            class="form-control" value="{{ $research['authors'] }}"
                                                            required>
                                                    </div>
                                                    <div class="mb-3 input-group input-group-outline">
                                                        <label class="form-label"></label>
                                                        <input type="text"
                                                            name="previousResearches[{{ $index }}][problem_statement]"
                                                            class="form-control"
                                                            value="{{ $research['problem_statement'] }}" required>
                                                    </div>
                                                    <div class="mb-3 input-group input-group-outline">
                                                        <label class="form-label"></label>
                                                        <input type="text"
                                                            name="previousResearches[{{ $index }}][results]"
                                                            class="form-control" value="{{ $research['results'] }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <button type="button"
                                                    class="btn btn-outline-danger remove-input ms-2 align-self-start">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" id="add-research"
                                        class="btn btn-sm btn-outline-primary">+</button>
                                </div>

                                <h4>VI. Rumusan Masalah</h4>
                                <div class="mb-3">
                                    <label for="researchQuestions" class="form-label">Rumusan Masalah</label>
                                    <div id="question-container" class="d-flex flex-column gap-2">
                                        @foreach (old('researchQuestions', $proposal->researchQuestions) as $index => $question)
                                            <div class="input-group mb-2 input-group-outline">
                                                <input type="text" name="researchQuestions[]" class="form-control"
                                                    value="{{ $question->question }}" required>
                                                <button type="button" class="btn btn-outline-danger remove-input">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" id="add-question"
                                        class="btn btn-sm btn-outline-primary">+</button>
                                </div>

                                <h4>VII. Output Penelitian</h4>
                                <div class="mb-3">
                                    <label for="outputs" class="form-label">Output Penelitian</label>
                                    <div id="output-container" class="d-flex flex-column gap-2">
                                        @foreach (old('outputs', $proposal->outputs) as $index => $output)
                                            <div class="input-group mb-2 input-group-outline">
                                                <input type="text" name="outputs[]" class="form-control"
                                                    value="{{ $output->research_output }}" required>
                                                <button type="button" class="btn btn-outline-danger remove-input">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" id="add-output"
                                        class="btn btn-sm btn-outline-primary">+</button>
                                </div>
                                <!-- Submit Button -->
                                <div class="d-flex justify-content-center mt-4">
                                    <button type="submit" class="btn btn-success">Update Proposal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let titleCount = 1;
        let reasonCount = 1;
        let researchCount = 1;
        let questionCount = 1;
        let outputCount = 1;

        // Add new title input
        document.getElementById('add-title').addEventListener('click', () => {
            titleCount++;
            const titleInputGroup = document.createElement('div');
            titleInputGroup.className = 'input-group mb-2 input-group-outline';
            titleInputGroup.innerHTML = `
                <input type="text" name="titles[]" class="form-control" placeholder="Alternatif Judul ${titleCount}" required>
                <button type="button" class="btn btn-outline-danger remove-input">
                    <i class="fa fa-trash"></i>
                </button>
            `;
            document.getElementById('title-container').appendChild(titleInputGroup);
        });

        // Add new reason input
        document.getElementById('add-reason').addEventListener('click', () => {
            reasonCount++;
            const reasonInputGroup = document.createElement('div');
            reasonInputGroup.className = 'input-group mb-2 input-group-outline';
            reasonInputGroup.innerHTML = `
                <input type="text" name="backgroundReasons[]" class="form-control" placeholder="Alasan ${reasonCount}" required>
                <button type="button" class="btn btn-outline-danger remove-input">
                    <i class="fa fa-trash"></i>
                </button>
            `;
            document.getElementById('reason-container').appendChild(reasonInputGroup);
        });

        // Add new research group
        document.getElementById('add-research').addEventListener('click', () => {
            const researchGroup = document.createElement('div');
            researchGroup.className = 'research-group mb-3 input-group input-group-outline';
            researchGroup.innerHTML = `
                <div class="d-flex flex-column flex-grow-1 gap-2">
                    <div class="mb-3 input-group input-group-outline">
                        <input type="text" name="previousResearches[${researchCount}][title]" class="form-control" placeholder="Judul Penelitian ${researchCount+1}" required>
                    </div>
                    <div class="mb-3 input-group input-group-outline">
                        <input type="text" name="previousResearches[${researchCount}][doi]" class="form-control" placeholder="DOI ${researchCount+1}" required>
                    </div>
                    <div class="mb-3 input-group input-group-outline">
                        <input type="text" name="previousResearches[${researchCount}][authors]" class="form-control" placeholder="Penulis ${researchCount+1}" required>
                    </div>
                    <div class="mb-3 input-group input-group-outline">
                        <input type="text" name="previousResearches[${researchCount}][problem_statement]" class="form-control" placeholder="Permasalahan yang Diangkat ${researchCount+1}" required>
                    </div>
                    <div class="mb-3 input-group input-group-outline">
                        <input type="text" name="previousResearches[${researchCount}][results]" class="form-control" placeholder="Hasil/Catatan Penelitian ${researchCount+1}" required>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-danger remove-input ms-2 align-self-start">
                    <i class="fa fa-trash"></i>
                </button>
            `;
            document.getElementById('research-container').appendChild(researchGroup);
            researchCount++;
        });

        // Add new question input for Rumusan Masalah
        document.getElementById('add-question').addEventListener('click', () => {
            questionCount++;
            const questionInputGroup = document.createElement('div');
            questionInputGroup.className = 'input-group mb-2 input-group-outline';
            questionInputGroup.innerHTML = `
            <input type="text" name="researchQuestions[]" class="form-control" placeholder="Rumusan Masalah ${questionCount}" required>
            <button type="button" class="btn btn-outline-danger remove-input">
                <i class="fa fa-trash"></i>
            </button>
        `;
            document.getElementById('question-container').appendChild(questionInputGroup);
        });

        // Add new output input for Output Penelitian
        document.getElementById('add-output').addEventListener('click', () => {
            outputCount++;
            const outputInputGroup = document.createElement('div');
            outputInputGroup.className = 'input-group mb-2 input-group-outline';
            outputInputGroup.innerHTML = `
            <input type="text" name="outputs[]" class="form-control" placeholder="Output Penelitian ${outputCount}" required>
            <button type="button" class="btn btn-outline-danger remove-input">
                <i class="fa fa-trash"></i>
            </button>
        `;
            document.getElementById('output-container').appendChild(outputInputGroup);
        });

        // Remove input on trash icon click
        document.addEventListener('click', (event) => {
            if (event.target.closest('.remove-input')) {
                event.target.closest('.input-group, .research-group').remove();
            }
        });
    });
</script>
