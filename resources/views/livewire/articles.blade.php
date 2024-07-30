<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="btn-group">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Per Page : {{ $perPage }}
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" wire:click.prevent="updatePerPage(2)">2</a></li>
                <li><a class="dropdown-item" href="#" wire:click.prevent="updatePerPage(5)">5</a></li>
                <li><a class="dropdown-item" href="#" wire:click.prevent="updatePerPage(10)">10</a></li>
                <li><a class="dropdown-item" href="#" wire:click.prevent="updatePerPage(20)">20</a></li>
            </ul>
        </div>
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="search" class="col-form-label">Search</label>
            </div>
            <div class="col-auto">
                <input wire:model.live.debounce.300ms="search" type="text" id="search" class="form-control" placeholder="search">
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table text-nowrap table-bordered">
            <thead>
                <tr>
                    <th scope="col" wire:click="setSortBy('title')">
                        Ttile
                        @if ($sortBy === 'title')
                            @if ($sortDir === 'asc')
                                <i class="ri-arrow-up-s-line"></i>
                            @else
                                <i class="ri-arrow-down-s-line"></i>
                            @endif
                        @else
                            <i class="ri-expand-up-down-fill"></i>
                        @endif
                    </th>
                    <th scope="col"wire:click="setSortBy('author')">Author
                        @if ($sortBy === 'author')
                            @if ($sortDir === 'asc')
                                <i class="ri-arrow-up-s-line"></i>
                            @else
                                <i class="ri-arrow-down-s-line"></i>
                            @endif
                        @else
                            <i class="ri-expand-up-down-fill"></i>
                        @endif
                    </th>
                    <th scope="col" wire:click="setSortBy('created_at')">Created On
                        @if ($sortBy === 'created_at')
                            @if ($sortDir === 'asc')
                                <i class="ri-arrow-up-s-line"></i>
                            @else
                                <i class="ri-arrow-down-s-line"></i>
                            @endif
                        @else
                            <i class="ri-expand-up-down-fill"></i>
                        @endif
                    </th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($articles as $article)
                <tr>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->author }}</td>
                    <td>{{ \Carbon\Carbon::parse($article->created_at)->format('d M, Y') }}</td>
                    <td>
                        <div class="hstack gap-2 flex-wrap">
                            <a href="{{route('articles.edit',$article->id)}}" class="text-info fs-14 lh-1"><i class="ri-edit-line"></i></a>
                            <a href="{{route('articles.destroy',$article->id)}}" onclick="confirmation(event)" class="text-danger fs-14 lh-1"><i class="ri-delete-bin-5-line"></i></a>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No permissions found.</td>
                    </tr>
                @endforelse
                    
                
                
            </tbody>
        </table>
        <!-- Pagination Links -->
        <div class="mb-3">
            {{ $articles->links('custom-pagination-links') }}
        </div>
    </div>
   @push('scripts')
        <script type="text/javascript">
            function confirmation(ev) {
        ev.preventDefault();
        var urlToRedirect = ev.currentTarget.getAttribute('href');
        
        Swal.fire({
            title: "Do you want to delete this permission?",
            showCancelButton: true,
            confirmButtonText: "Delete",
            cancelButtonText: "Cancel",
            icon: "warning"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = urlToRedirect;
            }
        });
        }
        </script>
   @endpush
</div>
