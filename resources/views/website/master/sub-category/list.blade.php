@extends('website.master')

@section('content')
<div class="container">
    <!-- Header Section -->
    <div class="row">
        <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-2">
            <h4 class="mb-0">Child Categories</h4>
            <a href="{{ route('child-categories.create') }}" class="btn btn-secondary">
                <i class="bi bi-plus-lg me-1"></i> Create Child Category
            </a>
        </div>
    </div>

    <!-- Table Section -->
    <div class="row">
        <div class="col-12">
            <div class="table-responsive bg-white p-3 shadow">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Parent Category</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($childCategories as $childCategory)
                        <tr>
                            <td>{{ $childCategory->name }}</td>
                            <td>{{ $childCategory->parentCategory->name }}</td>
                            <td>{{ $childCategory->description }}</td>
                            <td>
                                <a href="{{ route('child-categories.edit', $childCategory->id) }}"  class="btn btn-link text-info"><i class="ri-edit-line"></i></a>
                                <form action="{{ route('child-categories.destroy', $childCategory->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="ri-delete-bin-line"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $childCategories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
