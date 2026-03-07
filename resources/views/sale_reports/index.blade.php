@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            
            <!-- Filters Header -->
            <div class="card-header pb-0 border-bottom d-flex justify-content-between align-items-center mb-3">
                <h6>Sales Transactions Report</h6>
                
                <form action="{{ route('sale-reports.index') }}" method="GET" class="d-flex align-items-center">
                    <div class="me-3">
                        <label for="start_date" class="text-xs mb-0">Start Date</label>
                        <input type="date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}">
                    </div>
                    <div class="me-3">
                        <label for="end_date" class="text-xs mb-0">End Date</label>
                        <input type="date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary mb-0 mt-4 px-3">Filter</button>
                    @if(request('start_date') || request('end_date'))
                        <a href="{{ route('sale-reports.index') }}" class="btn btn-sm btn-outline-secondary mb-0 mt-4 ms-2 px-3">Clear</a>
                    @endif
                </form>
            </div>

            <!-- Aggregated Summary Cards for the Filtered Result -->
            <div class="card-body px-4 pt-0 pb-2">
                
                <div class="row mb-4">
                    <div class="col-md-6 mb-xl-0 mb-4">
                        <div class="card bg-gradient-success shadow">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-uppercase font-weight-bold text-white">Total Revenue (Filtered)</p>
                                            <h5 class="font-weight-bolder text-white">
                                                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div class="icon icon-shape bg-white shadow-success text-center rounded-circle">
                                            <i class="fas fa-coins text-lg opacity-10 text-success" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-xl-0 mb-4">
                        <div class="card bg-gradient-info shadow">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-uppercase font-weight-bold text-white">Transactions (Filtered)</p>
                                            <h5 class="font-weight-bolder text-white">
                                                {{ $totalTransactions }} Sales
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div class="icon icon-shape bg-white shadow-info text-center rounded-circle">
                                            <i class="fas fa-shopping-cart text-lg opacity-10 text-info" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Tabular Data -->
                <div class="table-responsive p-0 border rounded">
                    <table class="table align-items-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Transaction Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Sale ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Items Bought</th>
                                <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-4">Total Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $sale)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $sale->sale_date->format('d M Y') }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $sale->sale_date->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('sales.show', $sale->id) }}" class="text-xs font-weight-bold text-info mb-0 text-decoration-underline" target="_blank">
                                        #TRX-{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}
                                    </a>
                                </td>
                                <td>
                                    <ul class="text-xs mb-0 ps-3 text-secondary">
                                        @foreach($sale->saleDetails as $detail)
                                            <li>{{ $detail->sales_quantity }}x {{ $detail->product->name ?? $detail->serial_number_product }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="align-middle text-end px-4">
                                    <span class="text-sm font-weight-bold text-dark">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No records match the given date range.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-3">
                    {{ $sales->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
