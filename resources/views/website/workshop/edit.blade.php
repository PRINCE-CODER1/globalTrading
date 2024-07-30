@extends('website.master')

@section('content')
<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-3">
                <h4>Edit Workshop</h4>
                <a href="{{ route('workshops.index') }}" class="btn btn-outline-secondary btn-wave float-end">Back</a>
            </div>
        </div>
    </div>
    <div class="container">
    
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        <form action="{{ route('workshops.update', $workshop->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Workshop Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $workshop->name) }}" required>
            </div>
            <div class="form-group">
                <label for="branch_id">Branch</label>
                <select class="form-control" id="branch_id" name="branch_id" required>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('branch_id', $workshop->branch_id) == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
