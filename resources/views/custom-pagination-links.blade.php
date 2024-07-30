<nav aria-label="Page navigation mt-4" class="d-flex justify-content-between align-items-center mt-2">
    @if ($paginator->hasPages())
        <ul class="pagination justify-content-center mb-0">

            <li class="page-item">
                <span>
                    @if ($paginator->onFirstPage())
                        <span class="page-link disabled">Previous</span>
                    @else
                        <button wire:click="previousPage" class="page-link" wire:loading.attr="disabled"
                            rel="prev">Previous</button>
                    @endif
                </span>
            </li>
            <!--  <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0);"></a></li>-->

            <li class="page-item">
                <span>
                    @if ($paginator->onLastPage())
                        <span class="page-link disabled">Next</span>
                    @else
                        <button class="page-link page-link" wire:click="nextPage" wire:loading.attr="disabled"
                            rel="next">Next</button>
                    @endif
                </span>
            </li>

        </ul>
        <div class="text-center">
            <p class="text-sm text-gray-700 leading-5 mb-0">
                <span>{!! __('Showing') !!}</span>
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                <span>{!! __('to') !!}</span>
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                <span>{!! __('of') !!}</span>
                <span class="font-medium">{{ $paginator->total() }}</span>
                <span>{!! __('results') !!}</span>
            </p>
        </div>

    @endif

</nav>