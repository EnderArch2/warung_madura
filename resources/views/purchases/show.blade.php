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
    <div class="col-12 col-md-8 mx-auto">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between">
                <div>
                    <h5 class="mb-0">Purchase Order Receipt</h5>
                    <p class="text-sm text-secondary mb-0">{{ $purchase->note_number }}</p>
                </div>
                <div>
                    <a href="{{ route('purchases.index') }}" class="btn btn-sm btn-outline-secondary me-2 mb-0">Back to Purchases</a>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-6">
                        <span class="text-xs text-uppercase text-secondary font-weight-bolder">Purchase Date</span>
                        <h6 class="font-weight-bold">{{ $purchase->purchase_date->format('d F Y') }}</h6>
                    </div>
                    <div class="col-6">
                        <span class="text-xs text-uppercase text-secondary font-weight-bolder">Distributor</span>
                        <h6 class="font-weight-bold">{{ $purchase->distributor->name ?? 'Unknown' }}</h6>
                    </div>
                </div>

                @if($purchase->distributor)
                <div class="row mb-4">
                    <div class="col-6">
                        <span class="text-xs text-uppercase text-secondary font-weight-bolder">Address</span>
                        <p class="text-sm mb-0">{{ $purchase->distributor->address ?? 'N/A' }}</p>
                    </div>
                    <div class="col-6">
                        <span class="text-xs text-uppercase text-secondary font-weight-bolder">Phone</span>
                        <p class="text-sm mb-0">{{ $purchase->distributor->phone_number ?? 'N/A' }}</p>
                    </div>
                </div>
                @endif

                <h6>Line Items</h6>
                <div class="table-responsive p-0 mt-3 border rounded">
                    <table class="table align-items-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Purchase Price</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Margin</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty</th>
                                <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase->purchaseDetails as $detail)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{ $detail->product->name ?? $detail->serial_number_product }}</h6>
                                        <p class="text-xs text-secondary mb-0">SN: {{ $detail->serial_number_product }}</p>
                                    </div>
                                </td>
                                <td class="align-middle text-center px-4">
                                    <span class="text-xs font-weight-bold">Rp {{ number_format($detail->purchase_price, 0, ',', '.') }}</span>
                                </td>
                                <td class="align-middle text-center px-4">
                                    <span class="text-xs font-weight-bold text-info">Rp {{ number_format($detail->selling_margin, 0, ',', '.') }}</span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm bg-gradient-secondary">{{ $detail->purchase_amount }}</span>
                                </td>
                                <td class="align-middle text-end px-4">
                                    <span class="text-sm font-weight-bold text-dark">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                            @endforeach
                            <!-- Total Row -->
                            <tr class="bg-light">
                                <td colspan="4" class="text-end px-4 py-3">
                                    <h6 class="mb-0 text-uppercase">Grand Total</h6>
                                </td>
                                <td class="text-end px-4 py-3">
                                    <h5 class="mb-0 text-primary">Rp {{ number_format($purchase->total_price, 0, ',', '.') }}</h5>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <form action="{{ route('purchases.destroy', $purchase->note_number) }}" method="POST" class="d-inline" id="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">Delete This Order</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        if (confirm('Are you sure you want to delete this purchase order? Stock will be restored to products.')) {
            document.getElementById('delete-form').submit();
        }
    }
</script>
@endsection
