<x-layout bodyClass="g-sidenav-show  bg-gray-200" title="Profile Page">
    <x-navbars.sidebar activePage='user-profile'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Profile"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-6">
                    <div class="card shadow-lg">
                        @if (Session::get('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif
                        <div class="card-body text-center py-5">
                            @if (Auth::user()->image)
                                <img src="{{ asset('storage/images/users/' . Auth::user()->image) }}"
                                    alt="Profile Picture" class="profile-pic mb-4" id="profilePic"
                                    style="width: 150px;height: 150px; border-radius: 50%;object-fit:cover">
                            @else
                                <img src="https://via.placeholder.com/150" alt="Profile Picture"
                                    class="profile-pic mb-4" id="profilePic">
                            @endif
                            <h3 class="card-title h2 mb-3">{{ Auth::user()->name }}</h3>
                            <p class="card-text mb-2"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                            <p class="card-text mb-2"><strong>NIM:</strong> {{ Auth::user()->mahasiswa->nim }}</p>
                            <p class="card-text mb-2"><strong>Address:</strong> {{ Auth::user()->address ?? '-' }}</p>
                            <p class="card-text mb-2"><strong>Phone Number:</strong> {{ Auth::user()->phone ?? '-' }}
                            </p>
                            {{-- <p class="card-text mb-2"><strong>Date of Birth:</strong> {{Auth::user()->date_of_birth ?? '-'}}</p> --}}
                            <a href="{{ route('profile.edit') }}" class="btn bg-gradient-primary mt-4">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </div>
</x-layout>
