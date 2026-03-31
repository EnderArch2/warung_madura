@extends('layout.master')
@section('menu')
    @include('layout.menu')
@endsection
@section('users')
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
        navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('users.index') }}">Users</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $title }}</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">{{ $title }}</h6>
            </nav>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6>User Information</h6>
                            <span class="badge badge-lg bg-gradient-{{ $user->role === 'owner' ? 'danger' : ($user->role === 'admin' ? 'warning' : ($user->role === 'courier' ? 'info' : 'secondary')) }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="info-section">
                                    <label class="text-secondary text-xs font-weight-bold opacity-7">User ID</label>
                                    <p class="text-dark font-weight-bold">{{ $user->id }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="info-section">
                                    <label class="text-secondary text-xs font-weight-bold opacity-7">Full Name</label>
                                    <p class="text-dark font-weight-bold">{{ $user->name }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="info-section">
                                    <label class="text-secondary text-xs font-weight-bold opacity-7">Email Address</label>
                                    <p class="text-dark font-weight-bold">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="info-section">
                                    <label class="text-secondary text-xs font-weight-bold opacity-7">Phone Number</label>
                                    <p class="text-dark font-weight-bold">{{ $user->phone_number ?? 'Not provided' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="info-section">
                                    <label class="text-secondary text-xs font-weight-bold opacity-7">Address</label>
                                    <p class="text-dark font-weight-bold">{{ $user->address ?? 'Not provided' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="info-section">
                                    <label class="text-secondary text-xs font-weight-bold opacity-7">Email Status</label>
                                    @if($user->email_verified_at)
                                        <span class="badge badge-sm bg-gradient-success">Verified</span>
                                    @else
                                        <span class="badge badge-sm bg-gradient-secondary">Not Verified</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <hr class="horizontal dark my-4">

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="info-section">
                                    <label class="text-secondary text-xs font-weight-bold opacity-7">Created At</label>
                                    <p class="text-dark font-weight-bold">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="info-section">
                                    <label class="text-secondary text-xs font-weight-bold opacity-7">Last Updated</label>
                                    <p class="text-dark font-weight-bold">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back to List
                            </a>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                <i class="far fa-edit me-1"></i>Edit User
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer pt-3">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            © <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart"></i> by Warung Madura
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection
