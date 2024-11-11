<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Create Schedule Page">
    <x-navbars.sidebar activePage='jadwal-bimbingan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Create Schedules"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-body py-5">
                            <a href="{{ route('schedules.index') }}" class="btn btn-primary">Back</a>
                            <h3 class="card-title text-center mb-4">Buat Jadwal Bimbingan Baru</h3>

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

                            <!-- Schedule Creation Form -->
                            <form action="{{ route('schedules.store') }}" method="POST">
                                @csrf

                                <!-- Dosen ID -->
                                <input type="hidden" value="{{ Auth::user()->dosen->id }}" name="dosen_id">
                                <h6>Tanggal Bimbingan</h6>
                                <!-- Tanggal Bimbingan -->
                                <div class="mb-3 input-group input-group-outline">
                                    <label for="schedule_date" class="form-label"></label>
                                    <input type="date" name="schedule_date" id="schedule_date" class="form-control"
                                        required>
                                </div>

                                <h6>Waktu Mulai</h6>
                                <!-- Waktu Mulai -->
                                <div class="mb-3 input-group input-group-outline">
                                    <label for="start_time" class="form-label"></label>
                                    <input type="time" name="start_time" id="start_time" class="form-control"
                                        required>
                                </div>


                                <h6>Waktu Selesai</h6>
                                <!-- Waktu Selesai -->
                                <div class="mb-3 input-group input-group-outline">
                                    <label for="end_time" class="form-label"></label>
                                    <input type="time" name="end_time" id="end_time" class="form-control" required>
                                </div>

                                <h6>Tempat</h6>
                                <!-- Tempat -->
                                <div class="mb-3 input-group input-group-outline">
                                    <input type="text" name="location" id="location" class="form-control">
                                </div>

                                <h6>Kuota</h6>
                                <!-- Kuota -->
                                <div class="mb-3 input-group input-group-outline">
                                    <input type="number" name="quota" id="quota" class="form-control">
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-center mt-4">
                                    <button type="submit" class="btn btn-success">Submit Schedule</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
