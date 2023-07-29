@extends('layouts.admin')
@section('user', 'active')

@section('title', 'Admin User')

@section('content')
    <!-- Page Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">User</h2>
                <p class="dashboard-subtitle" style="color: gray">Tambah User Baru</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        {{-- Jika Terjadi Error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nama User</label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Email User</label>
                                                <input type="email" name="email" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password" name="password"
                                                    required>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="password-visibility-toggle">
                                                    <label class="form-check-label" for="password-visibility-toggle">Show
                                                        Password</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Roles</label>
                                                <select name="roles" class="form-control" required>
                                                    <option value="ADMIN">Admin</option>
                                                    <option value="OWNER">Pemilik</option>
                                                    <option value="USER">User</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <button type="submit" class="btn btn-store px-5">
                                                Save Now
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        const passwordInput = document.querySelector("#password");
        const passwordVisibilityToggle = document.querySelector("#password-visibility-toggle");

        passwordVisibilityToggle.addEventListener("change", function() {
            passwordInput.type = this.checked ? "text" : "password";
        });
    </script>
@endpush
