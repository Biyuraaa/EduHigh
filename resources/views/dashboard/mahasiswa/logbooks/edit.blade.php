<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Edit Logbook Page">
    <x-navbars.sidebar activePage='log-book'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Edit Logbook"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-primary p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="text-white mb-0">
                                    <i class="fas fa-book me-2"></i>Edit Logbook Konsultasi
                                </h4>
                                <a href="{{ route('logbooks.index') }}" class="btn btn-light">
                                    <i class="fas fa-arrow-left me-2"></i>Back
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <form action="{{ route('logbooks.update', $logbook) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row g-4">
                                    <!-- Supervisor Selection -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Select Supervisor</label>
                                            <select name="dosen_id"
                                                class="form-select @error('dosen_id') is-invalid @enderror" required>
                                                <option value="">Choose Supervisor</option>
                                                @foreach (Auth::user()->mahasiswa->superVisions as $supervisor)
                                                    <option value="{{ $supervisor->dosen->id }}"
                                                        {{ $logbook->superVision->dosen_id == $supervisor->dosen->id ? 'selected' : '' }}>
                                                        {{ $supervisor->dosen->user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('dosen_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Consultation Date -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Consultation Date</label>
                                            <input type="date" name="date"
                                                class="form-control @error('date') is-invalid @enderror" required
                                                value="{{ old('date', $logbook->date) }}">
                                            @error('date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Notes -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Consultation Notes</label>
                                            <textarea name="notes" rows="4" class="form-control @error('notes') is-invalid @enderror"
                                                placeholder="Enter consultation notes...">{{ old('notes', $logbook->notes) }}</textarea>
                                            @error('notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Percentage of Completion</label>
                                            <input type="number" name="percentage" min="0" max="100"
                                                class="form-control @error('percentage') is-invalid @enderror"
                                                placeholder="Enter percentage of completion" required
                                                value="{{ old('percentage', $logbook->percentage) }}">
                                            @error('percentage')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <input type="hidden" name="mahasiswa_id"
                                        value="{{ Auth::user()->mahasiswa->id }}">

                                    <!-- Submit Button -->
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Update Logbook
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

<style>
    .avatar-sm {
        width: 48px;
        height: 48px;
        overflow: hidden;
    }

    .avatar-sm img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .form-control-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #344767;
    }

    .form-control,
    .form-select {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        border: 1px solid #dee2e6;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #5e72e4;
        box-shadow: 0 0 0 0.2rem rgba(94, 114, 228, 0.25);
    }
</style>
