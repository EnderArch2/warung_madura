@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Sales Transactions</h6>
                <a href="{{ route('sales.create') }}" class="btn bg-gradient-primary btn-sm mb-0">Record New Sale</a>
            </div>
            
            <div class="card-body px-0 pt-0 pb-2">
                @if(session('success'))
                    <div class="alert alert-success mt-3 mx-4 text-white" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mt-3 mx-4 text-white" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sale ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Items Sold</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Price</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $sale)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">#TRX-{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $sale->sale_date->format('d M Y') }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm bg-gradient-info">{{ $sale->saleDetails->count() }} line items</span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</span>
                                </td>
                                <td class="align-middle" style="width: 250px;">
                                    <div class="d-flex justify-content-end px-3">
                                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-outline-info me-2 mb-0" data-toggle="tooltip" data-original-title="View Details">
                                            View
                                        </a>
                                        
                                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger mb-0 btn-delete">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">No sales recorded yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Pagination Links -->
        <div class="d-flex justify-content-center mt-3">
            {{ $sales->links() }}
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('.delete-form');
                
                Swal.fire({
                    title: 'Delete this Sale?',
                    text: "Deleting this sale will permanently remove it from reports and RESTORE the sold product stock.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ea0606',
                    cancelButtonColor: '#8392ab',
                    confirmButtonText: 'Yes, delete and restore stock'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        });
    });
</script>
@endsection
