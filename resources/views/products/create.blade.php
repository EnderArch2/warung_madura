@extends('layout.master')
@section('menu')
    @include('layout.menu')
@endsection

@section('products')
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
        navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-dark" aria-current="page">
                        <a href="{{ route('products.index') }}">{{ $title }}</a>
                    </li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Add New</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Add New Product</h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <ul class="navbar-nav justify-content-end">
                    <li class="nav-item d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                            <i class="fa fa-user me-sm-1"></i>
                            <span class="d-sm-inline d-none">Sign In</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Add New Product</h6>
                        <p class="text-sm mb-0">Fill in the product details below.</p>
                    </div>
                    <div class="card-body">

                        {{--
                            @if ($errors->any()) — $errors is automatically available in ALL views.
                            When validation fails, Laravel redirects back and stores the errors in the session.
                            The $errors variable is a MessageBag — a collection of field-level error messages.

                            @error('name') is a shorthand for @if($errors->has('name')) ... @endif
                            It also pulls the old() input value back into the field so the user
                            doesn't have to retype everything after a validation failure.
                        --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{--
                            action="{{ route('products.store') }}" → POST /products
                            enctype="multipart/form-data" is REQUIRED when the form has a file upload.
                            Without it, Laravel's $request->file('picture') returns NULL.
                        --}}
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            {{--
                                @csrf outputs: <input type="hidden" name="_token" value="randomstring">
                                This is Laravel's Cross-Site Request Forgery protection.
                                Every POST form MUST have this. Without it, Laravel throws a 419 error.
                                It prevents malicious websites from submitting forms to YOUR app on behalf of your users.
                            --}}
                            @csrf

                            <div class="row">
                                {{-- Serial Number --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Serial Number <span class="text-danger">*</span></label>
                                    {{--
                                        old('serial_number') — retrieves the value the user typed BEFORE validation failed.
                                        Without old(), every failed submission clears the form, frustrating users.
                                        @error appends the is-invalid CSS class for Bootstrap red border styling.
                                    --}}
                                    <input type="text" id="serial_number" name="serial_number"
                                        class="form-control @error('serial_number') is-invalid @enderror"
                                        value="{{ old('serial_number') }}"
                                        placeholder="e.g. PRD-001" maxlength="10" required>
                                    @error('serial_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Product Name --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}"
                                        placeholder="e.g. Indomie Goreng" maxlength="50" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Type / Category --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Type / Category <span class="text-danger">*</span></label>
                                    <input type="text" id="type" name="type"
                                        class="form-control @error('type') is-invalid @enderror"
                                        value="{{ old('type') }}"
                                        placeholder="e.g. Instant Noodles" maxlength="50" required>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Price --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Price (Rp)</label>
                                    <input type="number" id="price" name="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        value="{{ old('price') }}"
                                        placeholder="e.g. 3500" min="0">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Stock --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Stock</label>
                                    <input type="number" id="stock" name="stock"
                                        class="form-control @error('stock') is-invalid @enderror"
                                        value="{{ old('stock') }}"
                                        placeholder="e.g. 100" min="0">
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Expiration Date --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Expiration Date</label>
                                    <input type="date" id="expiration_date" name="expiration_date"
                                        class="form-control @error('expiration_date') is-invalid @enderror"
                                        value="{{ old('expiration_date') }}">
                                    @error('expiration_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Product Image --}}
                                <div class="col-12 mb-3">
                                    <label class="form-label">Product Picture</label>
                                    <input type="file" id="picture" name="picture"
                                        class="form-control @error('picture') is-invalid @enderror"
                                        accept="image/jpeg,image/png,image/jpg,image/webp">
                                    <small class="text-muted">Max 2MB. Accepted: JPG, PNG, WEBP</small>
                                    @error('picture')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn bg-gradient-dark">
                                    <i class="fas fa-save me-1"></i> Save Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer pt-3">
            <div class="container-fluid">
                <div class="copyright text-center text-sm text-muted">
                    © <script>document.write(new Date().getFullYear())</script>, Warung Madura
                </div>
            </div>
        </footer>
    </div>
@endsection
