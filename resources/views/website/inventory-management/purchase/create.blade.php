@extends('website.master')
@section('title', 'Create Purchase Order')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 mb-2">
            <h2 class="mb-0 d-flex justify-content-between align-items-center">Create Purchase</h2>
            <a href="{{ route('purchase.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-chevron-left me-1"></i> Back
            </a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('purchase.index') }}"><i class="ti ti-apps me-1 fs-15"></i>Purchase Orders</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Purchase</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="bg-white p-4 shadow-sm rounded">
        @livewire('inv-management.purchase-form')
    </div>
</div>

@endsection

@push('scripts')
<script>
    let itemIndex = 0;

    document.getElementById('add-item').addEventListener('click', function() {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <select name="items[${itemIndex}][product_id]" class="form-control" required>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="items[${itemIndex}][quantity]" class="form-control" required></td>
            <td><input type="number" name="items[${itemIndex}][price]" class="form-control" required></td>
            <td><input type="number" name="items[${itemIndex}][discount]" class="form-control"></td>
            <td>
                <select name="items[${itemIndex}][godown_id]" class="form-control" required>
                    @foreach($godowns as $godown)
                        <option value="{{ $godown->id }}">{{ $godown->name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="items[${itemIndex}][sub_total]" class="form-control" required></td>
            <td><button type="button" class="btn btn-danger remove-item">Remove</button></td>
        `;
        document.getElementById('items-table').appendChild(row);
        itemIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('tr').remove();
            itemIndex--;
        }
    });
</script>
@endpush
