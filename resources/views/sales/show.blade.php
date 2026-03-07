@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-12 col-md-8 mx-auto">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between">
                <div>
                    <h5 class="mb-0">Transaction Receipt</h5>
                    <p class="text-sm text-secondary mb-0">Record #TRX-{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div>
                    <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-secondary mb-0">Back to Sales</a>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-6">
                        <span class="text-xs text-uppercase text-secondary font-weight-bolder">Sale Date</span>
                        <h6 class="font-weight-bold">{{ $sale->sale_date->format('d F Y') }}</h6>
                    </div>
                </div>

                <h6>Line Items</h6>
                <div class="table-responsive p-0 mt-3 border rounded">
                    <table class="table align-items-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty</th>
                                <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-4">Price @ Unit</th>
                                <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sale->saleDetails as $detail)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{ $detail->product->name ?? $detail->serial_number_product }}</h6>
                                        <p class="text-xs text-secondary mb-0">SN: {{ $detail->serial_number_product }}</p>
                                    </div>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm bg-gradient-secondary">{{ $detail->sales_quantity }}</span>
                                </td>
                                <td class="align-middle text-end px-4">
                                    <span class="text-xs font-weight-bold">Rp {{ number_format($detail->selling_price, 0, ',', '.') }}</span>
                                </td>
                                <td class="align-middle text-end px-4">
                                    <span class="text-sm font-weight-bold text-dark">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                            @endforeach
                            <!-- Total Row -->
                            <tr class="bg-light">
                                <td colspan="3" class="text-end px-4 py-3">
                                    <h6 class="mb-0 text-uppercase">Grand Total</h6>
                                </td>
                                <td class="text-end px-4 py-3">
                                    <h5 class="mb-0 text-primary">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</h5>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
