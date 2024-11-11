<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Edit Schedule Page">
    <x-navbars.sidebar activePage='jadwal-bimbingan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Edit Jadwal Bimbingan"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12 col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title text-center h3 mb-0">Edit Jadwal Bimbingan</h3>
                            <a href="{{ route('schedules.index') }}" class="btn btn-primary">Back</a>
                        </div>
                        <div class="card-body py-5">
                            <form action="{{ route('schedules.update', $schedule) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <h6>Tanggal Bimbingan</h6>
                                <div class="mb-3 input-group input-group-outline">
                                    <label for="schedule_date" class="form-label"></label>
                                    <input type="date" id="schedule_date" name="schedule_date"
                                        class="form-control @error('schedule_date') is-invalid @enderror"
                                        value="{{ old('schedule_date', $schedule->schedule_date) }}" required>
                                    @error('schedule_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <h6>Waktu Mulai</h6>
                                <div class="mb-3 input-group input-group-outline">
                                    <label for="start_time" class="form-label"></label>
                                    <input type="time" id="start_time" name="start_time"
                                        class="form-control @error('start_time') is-invalid @enderror"
                                        value="{{ old('start_time', $schedule->start_time) }}" required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <h6>Waktu Selesai</h6>
                                <div class="mb-3 input-group input-group-outline">
                                    <label for="end_time" class="form-label"></label>
                                    <input type="time" id="end_time" name="end_time"
                                        class="form-control @error('end_time') is-invalid @enderror"
                                        value="{{ old('end_time', $schedule->end_time) }}" required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <h6>Tempat</h6>
                                <div class="mb-3 input-group input-group-outline">
                                    <label for="location" class="form-label"></label>
                                    <input type="text" id="location" name="location"
                                        class="form-control @error('location') is-invalid @enderror"
                                        value="{{ old('location', $schedule->location) }}" required>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <h6>Kuota</h6>
                                <div class="mb-3 input-group input-group-outline">
                                    <label for="quota" class="form-label"></label>
                                    <input type="number" id="quota" name="quota"
                                        class="form-control @error('quota') is-invalid @enderror"
                                        value="{{ old('quota', $schedule->quota) }}" required>
                                    @error('quota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success">Update Jadwal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
