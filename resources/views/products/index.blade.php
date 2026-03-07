@extends('layout.master')
@section('menu')
    @include('layout.menu')
@endsection

{{--
    @section('products') — This connects to @yield('products') in master.blade.php.
    The master layout uses @if ($title == 'Products') to decide which section to render.
    This is the "template inheritance" pattern in Blade:
    - master.blade.php = the skeleton (head, sidebar, footer scripts)
    - index.blade.php  = the body content for THIS specific page
--}}
@section('products')
    {{-- ============================================================
         NAVBAR (top bar with breadcrumb)
         This is the same navbar structure used in distributors/index.blade.php
         — copy-paste consistency is intentional so the app looks uniform.
    ============================================================ --}}
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
                </ul>
            </div>
        </div>
    </nav>
    {{-- End Navbar --}}

    {{-- ============================================================
         MAIN CONTENT
    ============================================================ --}}
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>{{ $title }} Table</h6>
                        {{--
                            route('products.create') generates: /products/create
                            Named routes are BETTER than hardcoded /products/create because:
                            if you ever rename the URL prefix, only web.php needs to change,
                            not every single href in every Blade file.
                        --}}
                        <a class="btn bg-gradient-dark btn-sm mb-0" href="{{ route('products.create') }}">
                            <i class="fas fa-plus me-1"></i> Add New Product
                        </a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">

                            {{--
                                Flash message from redirect()->with('success', '...')
                                The SweetAlert2 popup below handles this more elegantly,
                                but this inline alert is a fallback for non-JS browsers.
                            --}}
                            @if(session('success'))
                                <div class="alert alert-success mx-4 mt-3" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No.</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Serial No.</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Product Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Type</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Price</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Stock</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Expiry Date</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{--
                                        $products is a LengthAwarePaginator — it wraps the actual records.
                                        Looping over it with @foreach gives you Product model instances.

                                        WHY $loop->iteration instead of $no + 1?
                                        $loop is a magic Blade variable available inside @foreach.
                                        $loop->iteration is 1-indexed automatically.
                                        With pagination, numbering resets to 1 on each page,
                                        which is usually good UX.
                                    --}}
                                    @forelse ($products as $product)
                                        <tr>
                                            <td class="text-xs font-weight-bold mb-0 ps-2">{{ $loop->iteration }}.</td>
                                            <td class="text-xs font-weight-bold mb-0">
                                                <span class="badge badge-sm bg-gradient-secondary">{{ $product->serial_number }}</span>
                                            </td>
                                            <td class="text-xs font-weight-bold mb-0">{{ $product->name }}</td>
                                            <td class="text-xs font-weight-bold mb-0">{{ $product->type }}</td>
                                            <td class="text-xs font-weight-bold mb-0">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </td>
                                            <td class="text-xs font-weight-bold mb-0">
                                                {{-- Visual indicator: red badge for low stock (≤5), green for normal --}}
                                                @if ($product->stock <= 5)
                                                    <span class="badge badge-sm bg-gradient-danger">{{ $product->stock }}</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-success">{{ $product->stock }}</span>
                                                @endif
                                            </td>
                                            <td class="text-xs font-weight-bold mb-0">
                                                {{--
                                                    $product->expiration_date is a Carbon instance (due to $casts in the Model).
                                                    ->format() converts it to a readable string.
                                                    Without $casts, this would be a plain string and might look like "2025-11-12".
                                                --}}
                                                {{ $product->expiration_date ? $product->expiration_date->format('d M Y') : '-' }}
                                            </td>
                                            <td class="text-xs font-weight-bold mb-0">
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    {{--
                                                        @method('DELETE') outputs: <input type="hidden" name="_method" value="DELETE">
                                                        This is called "method spoofing". HTML forms only support GET and POST,
                                                        so Laravel checks for the hidden _method field to handle DELETE/PUT.
                                                    --}}
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                        data-name="{{ $product->name }}">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        {{-- @forelse/@empty: shows this row when $products is empty --}}
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-muted">
                                                No products found. <a href="{{ route('products.create') }}">Add your first product →</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{--
                                $products->links() renders Bootstrap-compatible pagination buttons.
                                This only works because we used paginate() in the controller,
                                NOT all() which returns a plain Collection.
                                To style with Bootstrap:  AppServiceProvider::boot() → Paginator::useBootstrap()
                            --}}
                            <div class="px-4 pt-3">
                                {{ $products->links() }}
                            </div>
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
                            © <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart"></i> by
                            <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection

@push('scripts')
{{-- SweetAlert2 CDN — used for prettier delete confirmation dialogs --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Show success toast popup if the session has a 'success' flash message --}}
@if(session('success'))
<script>
    Swal.fire({
        title: 'Success!',
        text: '{{ session('success') }}',
        icon: 'success',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif

{{--
    DELETE CONFIRMATION — Two-step SweetAlert confirmation before deleting.
    WHY two steps?
    Accidental deletion is one of the most common user mistakes. A double
    confirmation significantly reduces accidental destructive actions.
--}}
<script>
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            const form = this.closest('form');
            const name = this.getAttribute('data-name');

            Swal.fire({
                title: 'Delete "' + name + '"?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then(result => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
