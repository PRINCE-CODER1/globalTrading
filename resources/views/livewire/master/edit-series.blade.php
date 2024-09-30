<div>
    <form wire:submit.prevent="submit">
        <!-- Stock Category Field -->
        <div class="mb-3">
            <label for="stock_category_id" class="form-label fs-14 text-dark">
                <i class="bi bi-box-seam me-1"></i> Stock Category <sup class="text-danger">*</sup>
            </label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                <select wire:model.live.debounce.500ms="stock_category_id" id="stock_category_id" class="form-control" required>
                    <option value="">Select a Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('stock_category_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="child_category_id" class="form-label fs-14 text-dark">
                <i class="bi bi-box-seam me-1"></i> Child Category <sup class="text-danger">*</sup>
            </label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                <select wire:model="child_category_id" id="child_category_id" class="form-control" required>
                    <option value="" >Select a Child Category</option>
                    @foreach($childCategories as $childCategory)
                        <option value="{{ $childCategory->id }}">
                            {{ $childCategory->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('child_category_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Name Field -->
        <div class="mb-3">
            <label for="name" class="form-label fs-14 text-dark">
                <i class="bi bi-tag me-1"></i> Name <sup class="text-danger">*</sup>
            </label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                <input type="text" wire:model="name" id="name" class="form-control" required>
            </div>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description Field -->
        <div class="mb-3">
            <label for="description" class="form-label fs-14 text-dark">
                <i class="bi bi-file-earmark-text me-1"></i> Description
            </label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                <textarea wire:model="description" id="description" class="form-control"></textarea>
            </div>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-secondary">
            <i class="bi bi-save me-1"></i> Save
        </button>
    </form>
</div>
