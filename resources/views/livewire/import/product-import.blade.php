<div>
    <form wire:submit.prevent="import" enctype="multipart/form-data">
        <div class="form-group">
            <label for="file">Import Excel File</label>
            <input type="file" wire:model="file" class="form-control">
            
            @error('file') 
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Import Products</button>
    </form>

    @if (session()->has('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif
</div>
