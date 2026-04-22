@extends('layout.master')
@section('menu')
    @include('layout.menu')
@endsection
@section('content')
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
                        <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                            aria-labelledby="dropdownMenuButton">
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="javascript:;">
                                    <div class="d-flex py-1">
                                        <div class="my-auto">
                                            <img src="{{ asset('layout/assets/img/team-2.jpg') }}"
                                                class="avatar avatar-sm  me-3 ">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                <span class="font-weight-bold">New message</span> from Laur
                                            </h6>
                                            <p class="text-xs text-secondary mb-0 ">
                                                <i class="fa fa-clock me-1"></i>
                                                13 minutes ago
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="javascript:;">
                                    <div class="d-flex py-1">
                                        <div class="my-auto">
                                            <img src="{{ asset('layout/assets/img/small-logos/logo-spotify.svg') }}"
                                                class="avatar avatar-sm bg-gradient-dark  me-3 ">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                <span class="font-weight-bold">New album</span> by Travis Scott
                                            </h6>
                                            <p class="text-xs text-secondary mb-0 ">
                                                <i class="fa fa-clock me-1"></i>
                                                1 day
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item border-radius-md" href="javascript:;">
                                    <div class="d-flex py-1">
                                        <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                                            <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <title>credit-card</title>
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF"
                                                        fill-rule="nonzero">
                                                        <g transform="translate(1716.000000, 291.000000)">
                                                            <g transform="translate(453.000000, 454.000000)">
                                                                <path class="color-background"
                                                                    d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                                                    opacity="0.593633743"></path>
                                                                <path class="color-background"
                                                                    d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                Payment successfully completed
                                            </h6>
                                            <p class="text-xs text-secondary mb-0 ">
                                                <i class="fa fa-clock me-1"></i>
                                                2 days
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="row">
        <div class="col-12 col-xl-10 mx-auto">
            <div class="card mb-4 border border-primary">
                <div class="card-header pb-0">
                    {{-- <h6>Add New {{ $title }} Data</h6> --}}
                    {{-- <input type="text" class="form-control fs-1 fw-bold bg-primary text-white text-center"
                        id="total_bayar" name="total_bayar" placeholder="Enter Total Pay"
                        value="@if (isset(session('data')->total_price)) {{ session('data')->total_price }}@else{{ old('total_price') ? old('total_price') : 'Rp,-' }} @endif"
                        disabled> --}}
                        <h3 id="grand-total-display" class="fs-1 fw-bold bg-primary text-white text-center rounded">Rp 0</h3>
                </div>
                <div class="card-header pb-0 border-bottom">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-secondary mb-0 me-3">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <h6 class="mb-0">Point of Sale (New Transaction)</h6>
                    </div>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger text-white">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger text-white">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('sales.store') }}" method="POST" id="pos-form">
                        @csrf

                        <div class="row">
                            <!-- Left Side: Transaction Meta -->
                            <div class="col-md-4 border-end">
                                <h6 class="text-sm">Transaction Details</h6>
                                <div class="form-group">
                                    <label for="sale_date">Sale Date</label>
                                    <input type="date" name="sale_date" id="sale_date" class="form-control mb-3" required
                                        value="{{ old('sale_date', date('Y-m-d')) }}">
                                </div>

                                {{-- <div class="bg-light p-3 border-radius-lg mt-4 text-center">
                                    <p class="text-sm mb-0"><b>Estimated Total</b></p>
                                    <h3 id="grand-total-display" class="text-primary mb-0">Rp 0</h3>
                                    <small class="text-muted text-xxs">(Calculated dynamically)</small>
                                </div> --}}

                                <button type="submit" class="btn bg-gradient-success w-100 mt-4 mb-0" id="btn-submit"
                                    disabled>
                                    Complete Transaction
                                </button>
                            </div>

                            <!-- Right Side: Dynamic Product Cart -->
                            <div class="col-md-8">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <b>Cart Items</b>
                                    <button type="button" class="btn btn-sm btn-outline-primary mb-0" id="btn-add-row">
                                        + Add Item
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0" id="cart-table">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2">
                                                    Product</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2"
                                                    style="width: 120px;">Price</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2"
                                                    style="width: 100px;">Qty</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2"
                                                    style="width: 120px;">Subtotal</th>
                                                <th class="text-secondary opacity-7 px-2" style="width: 50px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="cart-body">
                                            <!-- Rows dynamically added via Javascript -->
                                        </tbody>
                                    </table>
                                </div>
                                <p id="empty-cart-msg" class="text-center text-sm text-muted mt-3">Your cart is empty. Click
                                    "+ Add Item" to begin.</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ==========================================
                 VUE-LIKE VANILLA JS POS SYSTEM
                 ========================================== -->
    <script>
        // 1. We load all products from server into a JSON array to handle dynamic pricing lookups on the client.
        const productsList = {!! json_encode($productsList) !!};

        document.addEventListener('DOMContentLoaded', function() {
            const cartBody = document.getElementById('cart-body');
            const emptyMsg = document.getElementById('empty-cart-msg');
            const btnAddRow = document.getElementById('btn-add-row');
            const displayTotal = document.getElementById('grand-total-display');
            const btnSubmit = document.getElementById('btn-submit');

            let rowCount = 0;

            // Formats numbers as Indonesian Rupiah
            const formatRupiah = (number) => {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(number);
            };

            // Recalculates the entire cart
            const calculateTotals = () => {
                let total = 0;
                const rows = cartBody.querySelectorAll('tr');

                rows.forEach(row => {
                    const selectElement = row.querySelector('.product-select');
                    const qtyElement = row.querySelector('.qty-input');
                    const subtotalElement = row.querySelector('.subtotal-display');

                    const selectedOption = selectElement.options[selectElement.selectedIndex];
                    const price = parseFloat(selectedOption.dataset.price) || 0;
                    const qty = parseInt(qtyElement.value) || 0;

                    const subtotal = price * qty;
                    subtotalElement.textContent = formatRupiah(subtotal);

                    total += subtotal;
                });

                displayTotal.textContent = formatRupiah(total);

                // Enable/disable submit button based on cart state
                if (rows.length > 0 && total > 0) {
                    btnSubmit.disabled = false;
                    emptyMsg.style.display = 'none';
                } else {
                    btnSubmit.disabled = true;
                    emptyMsg.style.display = 'block';
                }
            };

            // Creates a new <option> dropdown for a cart row
            const createProductOptions = () => {
                let html = '<option value="" data-price="0" disabled selected>-- Select Product --</option>';
                productsList.forEach(p => {
                    const stockWarning = p.stock <= 0 ? ' (Out of stock)' : ` (${p.stock} in stock)`;
                    const disabled = p.stock <= 0 ? 'disabled' : '';
                    html += `<option value="${p.serial}" data-price="${p.price}" data-stock="${p.stock}" ${disabled}>
                            ${p.name} - ${formatRupiah(p.price)}${stockWarning}
                         </option>`;
                });
                return html;
            };

            // Adds a new row to the table
            btnAddRow.addEventListener('click', function() {
                rowCount++;
                const tr = document.createElement('tr');
                tr.innerHTML = `
                <td class="px-2">
                    <select class="form-control form-control-sm product-select" name="product_serial[]" required>
                        ${createProductOptions()}
                    </select>
                </td>
                <td class="text-center px-2">
                    <span class="text-xs price-display font-weight-bold line-height-1">Rp 0</span>
                </td>
                <td class="px-2">
                    <input type="number" class="form-control form-control-sm text-center qty-input" name="quantity[]" min="1" value="1" required>
                </td>
                <td class="text-center px-2">
                    <span class="text-sm subtotal-display font-weight-bolder text-primary">Rp 0</span>
                </td>
                <td class="text-center px-2">
                    <button type="button" class="btn btn-sm btn-link text-danger mb-0 px-2 btn-remove-row"><i class="fas fa-trash"></i></button>
                </td>
            `;
                cartBody.appendChild(tr);
                calculateTotals();
            });

            // Event Delegation for dynamically added elements
            cartBody.addEventListener('change', (e) => {
                if (e.target.classList.contains('product-select')) {
                    // When a product is selected, update its price display and validate max qty
                    const selectElement = e.target;
                    const row = selectElement.closest('tr');
                    const priceDisplay = row.querySelector('.price-display');
                    const qtyInput = row.querySelector('.qty-input');

                    const selectedOption = selectElement.options[selectElement.selectedIndex];
                    const price = parseFloat(selectedOption.dataset.price) || 0;
                    const stock = parseInt(selectedOption.dataset.stock) || 0;

                    priceDisplay.textContent = formatRupiah(price);
                    qtyInput.max = stock; // Prevent ordering more than in stock

                    if (parseInt(qtyInput.value) > stock) {
                        qtyInput.value = stock;
                    }

                    calculateTotals();
                }
            });

            cartBody.addEventListener('input', (e) => {
                if (e.target.classList.contains('qty-input')) {
                    // Validate stock limit dynamically on typing
                    const qtyInput = e.target;
                    const row = qtyInput.closest('tr');
                    const selectElement = row.querySelector('.product-select');
                    const selectedOption = selectElement.options[selectElement.selectedIndex];

                    if (selectedOption && selectedOption.value !== "") {
                        const stock = parseInt(selectedOption.dataset.stock);
                        if (parseInt(qtyInput.value) > stock) {
                            alert(`Cannot exceed available stock (${stock} units)`);
                            qtyInput.value = stock;
                        }
                    }
                    calculateTotals();
                }
            });

            cartBody.addEventListener('click', (e) => {
                if (e.target.closest('.btn-remove-row')) {
                    const row = e.target.closest('tr');
                    row.remove();
                    calculateTotals();
                }
            });

            // Add first row by default
            btnAddRow.click();
        });
    </script>

@endsection
