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
                </ul>
            </div>
        </div>
    </nav>
<div class="row">
    <div class="col-12 col-xl-10 mx-auto">
        <div class="card mb-4">
            <div class="card-header pb-0 border-bottom">
                <div class="d-flex align-items-center">
                    <a href="{{ route('purchases.index') }}" class="btn btn-sm btn-outline-secondary mb-0 me-3">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <h6 class="mb-0">Create New Purchase Order</h6>
                </div>
            </div>

            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger text-white">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger text-white">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('purchases.store') }}" method="POST" id="purchase-form">
                    @csrf

                    <div class="row">
                        <!-- Left Side: Purchase Meta -->
                        <div class="col-md-4 border-end">
                            <h6 class="text-sm">Purchase Details</h6>

                            <div class="form-group">
                                <label for="purchase_date">Purchase Date</label>
                                <input type="date" name="purchase_date" id="purchase_date" class="form-control mb-3" required value="{{ old('purchase_date', date('Y-m-d')) }}">
                            </div>

                            <div class="form-group">
                                <label for="distributor_id">Distributor</label>
                                <select name="distributor_id" id="distributor_id" class="form-control mb-3" required>
                                    <option value="">-- Select Distributor --</option>
                                    @foreach($distributors as $distributor)
                                        <option value="{{ $distributor->id }}" {{ old('distributor_id') == $distributor->id ? 'selected' : '' }}>
                                            {{ $distributor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="bg-light p-3 border-radius-lg mt-4 text-center">
                                <p class="text-sm mb-0"><b>Estimated Total</b></p>
                                <h3 id="grand-total-display" class="text-primary mb-0">Rp 0</h3>
                                <small class="text-muted text-xxs">(Calculated dynamically)</small>
                            </div>

                            <button type="submit" class="btn bg-gradient-success w-100 mt-4 mb-0" id="btn-submit" disabled>
                                Save Purchase Order
                            </button>
                        </div>

                        <!-- Right Side: Dynamic Product Cart -->
                        <div class="col-md-8">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <b>Purchase Items</b>
                                <button type="button" class="btn btn-sm btn-outline-primary mb-0" id="btn-add-row">
                                    + Add Item
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-items-center mb-0" id="cart-table">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2">Product</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2" style="width: 100px;">Purchase Price</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2" style="width: 80px;">Margin</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2" style="width: 80px;">Qty</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2" style="width: 120px;">Subtotal</th>
                                            <th class="text-secondary opacity-7 px-2" style="width: 50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="cart-body">
                                        <!-- Rows dynamically added via Javascript -->
                                    </tbody>
                                </table>
                            </div>
                            <p id="empty-cart-msg" class="text-center text-sm text-muted mt-3">Your cart is empty. Click "+ Add Item" to begin.</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================
     PURCHASE FORM DYNAMIC ITEM HANDLER
     ========================================== -->
<script>
    // Load all products from server into a JSON array for dynamic pricing lookups
    const productsList = {!! json_encode($productsList) !!};

    document.addEventListener('DOMContentLoaded', function() {
        const cartBody = document.getElementById('cart-body');
        const emptyMsg = document.getElementById('empty-cart-msg');
        const btnAddRow = document.getElementById('btn-add-row');
        const btnSubmit = document.getElementById('btn-submit');
        const grandTotalDisplay = document.getElementById('grand-total-display');

        // Function to create a new product row
        function createProductRow(rowIndex = null) {
            const index = rowIndex !== null ? rowIndex : cartBody.children.length;
            const row = document.createElement('tr');
            row.className = 'product-row';
            row.dataset.index = index;

            row.innerHTML = `
                <td class="px-2">
                    <select name="product_serial[]" class="form-select form-select-sm product-select" required>
                        <option value="">-- Select Product --</option>
                        ${productsList.map(p => `<option value="${p.serial}">${p.name} (Stock: ${p.stock})</option>`).join('')}
                    </select>
                </td>
                <td class="text-center px-2">
                    <input type="number" name="purchase_price[]" class="form-control form-control-sm purchase-price text-center" min="1" required placeholder="0">
                </td>
                <td class="text-center px-2">
                    <input type="number" name="selling_margin[]" class="form-control form-control-sm selling-margin text-center" min="0" value="0" required>
                </td>
                <td class="text-center px-2">
                    <input type="number" name="purchase_amount[]" class="form-control form-control-sm quantity text-center" min="1" value="1" required>
                </td>
                <td class="text-center px-2">
                    <input type="text" class="form-control form-control-sm subtotal text-center" disabled value="Rp 0" readonly>
                </td>
                <td class="text-center px-2">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row mb-0">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

            // Attach event listeners to the row
            const priceInput = row.querySelector('.purchase-price');
            const marginInput = row.querySelector('.selling-margin');
            const quantityInput = row.querySelector('.quantity');
            const subtotalDisplay = row.querySelector('.subtotal');
            const removeBtn = row.querySelector('.btn-remove-row');

            // Update subtotal when any field changes
            const updateSubtotal = () => {
                const price = parseFloat(priceInput.value) || 0;
                const quantity = parseFloat(quantityInput.value) || 0;
                const subtotal = price * quantity;
                subtotalDisplay.value = 'Rp ' + subtotal.toLocaleString('id-ID', {minimumFractionDigits: 0});
                updateGrandTotal();
            };

            priceInput.addEventListener('input', updateSubtotal);
            quantityInput.addEventListener('input', updateSubtotal);
            marginInput.addEventListener('input', updateGrandTotal);
            removeBtn.addEventListener('click', () => {
                row.remove();
                updateUI();
            });

            return row;
        }

        // Update grand total from all rows
        function updateGrandTotal() {
            let grandTotal = 0;
            document.querySelectorAll('.product-row').forEach(row => {
                const price = parseFloat(row.querySelector('.purchase-price').value) || 0;
                const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
                grandTotal += price * quantity;
            });

            grandTotalDisplay.textContent = 'Rp ' + grandTotal.toLocaleString('id-ID', {minimumFractionDigits: 0});
        }

        // Update UI visibility
        function updateUI() {
            const hasItems = cartBody.children.length > 0;
            emptyMsg.style.display = hasItems ? 'none' : 'block';
            btnSubmit.disabled = !hasItems;
            updateGrandTotal();
        }

        // Add row button
        btnAddRow.addEventListener('click', () => {
            const newRow = createProductRow();
            cartBody.appendChild(newRow);
            updateUI();
        });

        // Initialize with one empty row if form hasn't been submitted yet
        // (or restore rows if editing)
        if (cartBody.children.length === 0) {
            const newRow = createProductRow();
            cartBody.appendChild(newRow);
        }
        updateUI();
    });
</script>
@endsection
