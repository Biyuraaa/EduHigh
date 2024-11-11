<x-layout bodyClass="g-sidenav-show  bg-gray-200" title="Edit Profile Page">
    <x-navbars.sidebar activePage='user-profile'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Edit Profile"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-body text-center py-5">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('profile.update') }}" id="profileForm" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-4 text-center">
                                    <img src="{{ Auth::user()->image ? asset('storage/images/users/' . Auth::user()->image) : 'https://via.placeholder.com/150' }}"
                                        alt="Profile Picture" class="profile-pic" id="profilePic"
                                        style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover">
                                    <input type="file" class="form-control mt-3" name="image" id="profilePicInput"
                                        accept="image/*">
                                </div>
                                <div class="input-group input-group-outline mb-4">
                                    <label for="email" class="form-label"></label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="{{ Auth::user()->email }}" disabled>
                                </div>
                                @if (Auth::user()->role == 'mahasiswa')
                                    <div class="input-group input-group-outline mb-4">
                                        <label for="nim" class="form-label"></label>
                                        <input type="text" class="form-control" name="nim" id="nim"
                                            value="{{ Auth::user()->mahasiswa->nim }}" disabled>
                                    </div>
                                @else
                                    <div class="input-group input-group-outline mb-4">
                                        <label for="nidn" class="form-label"></label>
                                        <input type="text" class="form-control" name="nidn" id="nidn"
                                            value="{{ Auth::user()->dosen->nidn }}" disabled>
                                    </div>
                                @endif
                                <div class="input-group input-group-static mb-4">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ Auth::user()->name }}">
                                </div>
                                <div class="input-group input-group-static mb-4">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" name="address" id="address"
                                        value="{{ Auth::user()->address }}" placeholder="Enter your address">
                                </div>
                                <div class="input-group input-group-static mb-4">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" name="phone" id="phone"
                                        value="{{ Auth::user()->phone }}" placeholder="Enter your phone number">
                                </div>
                                <div class="input-group input-group-static mb-4">
                                    <label for="date_of_birth">Date of Birth</label>
                                    <input type="date" class="form-control" name="date_of_birth" id="date_of_birth"
                                        value="{{ Auth::user()->date_of_birth }}"
                                        placeholder="Enter your date of birth">
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </div>

    <script>
        document.getElementById('profilePicInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('profilePic').src = e.target.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-layout>
