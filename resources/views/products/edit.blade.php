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
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Edit Product: {{ $product->name }}</h6>
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
                        <h6>Edit Product</h6>
                        <p class="text-sm mb-0">Update the product details below.</p>
                    </div>
                    <div class="card-body">

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
                            action="{{ route('products.update', $product->id) }}" → PUT /products/{id}
                            @method('PUT') adds the hidden _method field for method spoofing.

                            WHY do we pass $product->id to route()?
                            route('products.update', $product->id) generates:  /products/5
                            You can also use:  route('products.update', $product)  — Laravel is smart
                            enough to call $product->getRouteKey() which returns the id automatically.
                        --}}
                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Serial Number <span class="text-danger">*</span></label>
                                    {{--
                                        old('serial_number', $product->serial_number) — two-argument old():
                                        - 1st arg: the session key to look for (set after a failed validation)
                                        - 2nd arg: the fallback value (the current product value on first load)
                                        On first load → shows $product->serial_number
                                        After validation fails → shows what the user typed (old value)
                                    --}}
                                    <input type="text" id="serial_number" name="serial_number"
                                        class="form-control @error('serial_number') is-invalid @enderror"
                                        value="{{ old('serial_number', $product->serial_number) }}"
                                        maxlength="10" required>
                                    @error('serial_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $product->name) }}"
                                        maxlength="50" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Type / Category <span class="text-danger">*</span></label>
                                    <input type="text" id="type" name="type"
                                        class="form-control @error('type') is-invalid @enderror"
                                        value="{{ old('type', $product->type) }}"
                                        maxlength="50" required>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Price (Rp)</label>
                                    <input type="number" id="price" name="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        value="{{ old('price', $product->price) }}"
                                        min="0">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Stock</label>
                                    <input type="number" id="stock" name="stock"
                                        class="form-control @error('stock') is-invalid @enderror"
                                        value="{{ old('stock', $product->stock) }}"
                                        min="0">
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Expiration Date</label>
                                    <input type="date" id="expiration_date" name="expiration_date"
                                        class="form-control @error('expiration_date') is-invalid @enderror"
                                        value="{{ old('expiration_date', $product->expiration_date ? $product->expiration_date->format('Y-m-d') : '') }}">
                                    @error('expiration_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Image Upload with preview of current image --}}
                                <div class="col-12 mb-3">
                                    <label class="form-label">Product Picture</label>
                                    @if ($product->picture)
                                        <div class="mb-2">
                                            <p class="text-sm text-muted mb-1">Current image:</p>
                                            <img src="{{ asset('storage/' . $product->picture) }}"
                                                alt="{{ $product->name }}"
                                                style="height: 80px; border-radius: 8px; object-fit: cover;">
                                        </div>
                                    @endif
                                    <input type="file" id="picture" name="picture"
                                        class="form-control @error('picture') is-invalid @enderror"
                                        accept="image/jpeg,image/png,image/jpg,image/webp">
                                    <small class="text-muted">Leave empty to keep the current image. Max 2MB.</small>
                                    @error('picture')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn bg-gradient-warning">
                                    <i class="fas fa-save me-1"></i> Update Product
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
