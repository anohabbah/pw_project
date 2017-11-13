@if ($paginator->hasPages())
    <nav class="pagination is-small" role="navigation" aria-label="pagination">
        @if ($paginator->onFirstPage())
            <a class="is-disabled pagination-previous"><span>@lang('pagination.previous')</span></a>
        @else
            <a class="pagination-previous"
               href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
        @endif

        @if ($paginator->hasMorePages())
            <a class="pagination-next" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
        @else
            <a class="is-disabled pagination-next"><span>@lang('pagination.next')</span></a>
        @endif
    </nav>
@endif
