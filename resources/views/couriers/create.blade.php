@extends('layout.master')
@section('menu')
    @include('layout.menu')
@endsection
@section('couriers')
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
        navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $title }}</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">{{ $title }}</h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <div class="input-group">
                        <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" placeholder="Type here...">
                    </div>
                </div>
                <ul class="navbar-nav  justify-content-end">
                    <li class="nav-item d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                            <i class="fa fa-user me-sm-1"></i>
                            <span class="d-sm-inline d-none">Sign In</span>
                        </a>
                    </li>
                    <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item px-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0">
                            <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown pe-2 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell cursor-pointer"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Create New {{ $title }}</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <div class="card-body" style="width: 700px">
                                @if(
                                    $errors->any()
                                )
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form role="form" id="courierForm" action="{{ route('couriers.store') }}" method="POST">
                                    @csrf
                                    <label>Name</label>
                                    <div class="mb-3">
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Input Courier's Name"
                                            aria-label="Name" aria-describedby="name-addon" required value="{{ old('name') }}">
                                    </div>
                                    <label>Email</label>
                                    <div class="mb-3">
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Input Courier's Email"
                                            aria-label="Email" aria-describedby="email-addon" required value="{{ old('email') }}">
                                    </div>
                                    <label>Password</label>
                                    <div class="mb-3">
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="Input Courier's Password" aria-label="Password"
                                            aria-describedby="password-addon" required>
                                    </div>
                                    <label>Phone Number</label>
                                    <div class="mb-3">
                                        <input type="text" name="phone_number" class="form-control" id="phone"
                                            placeholder="Input Courier's Phone Number" aria-label="PhoneNumber"
                                            aria-describedby="phoneNumber-addon" value="{{ old('phone_number') }}">
                                    </div>
                                    <label>Address</label>
                                    <div class="mb-3">
                                        <textarea name="address" class="form-control" id="address"
                                            placeholder="Input Courier's Address" aria-label="Address"
                                            aria-describedby="address-addon">{{ old('address') }}</textarea>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn bg-gradient-danger mt-4 mb-0" id="cancelBtn"
                                            style="justify-self: flex-end" onclick="history.back()">Cancel</button>
                                        <button type="submit" class="btn bg-gradient-info mt-4 mb-0" id="submitBtn"
                                            style="justify-self: flex-end">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer pt-3  ">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>,
                            made with <i class="fa fa-heart"></i> by
                            <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative
                                Tim</a>
                            for a better web.
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection
