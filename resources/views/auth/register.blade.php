<x-layout bodyClass="bg-gray-200" title="Register Page">
    <main class="main-content mt-0">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container mt-5">
                <div class="row signin-margin">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign up</h4>
                                    <div class="row mt-3">
                                        <h6 class='text-white text-center'>
                                            <span class="font-weight-normal">Welcome, please enter your information to
                                                sign up</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <!-- Input for Name -->
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name') }}">
                                    </div>
                                    @error('name')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror

                                    <!-- Input for NIM (Mahasiswa only) -->
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">NIM</label>
                                        <input type="text" class="form-control" name="nim"
                                            value="{{ old('nim') }}">
                                    </div>
                                    @error('nim')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror

                                    <!-- Input for Email -->
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror

                                    <!-- Input for Password -->
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password">
                                    </div>
                                    @error('password')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror

                                    <!-- Input for Confirm Password -->
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" name="password_confirmation">
                                    </div>
                                    @error('password_confirmation')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror

                                    <!-- Terms and Conditions Checkbox -->
                                    <div class="form-check form-check-info text-start ps-0 mt-3">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            I agree to the <a href="javascript:;"
                                                class="text-dark font-weight-bolder">Terms and Conditions</a>
                                        </label>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-center">
                                        <button type="submit"
                                            class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Sign
                                            Up</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-2 text-sm mx-auto">
                                    Already have an account?
                                    <a href="{{ route('login') }}"
                                        class="text-primary text-gradient font-weight-bold">Sign in</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('js')
        <script src="{{ asset('assets') }}/js/jquery.min.js"></script>
    @endpush
</x-layout>
