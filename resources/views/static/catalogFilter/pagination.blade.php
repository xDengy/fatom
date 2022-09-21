@if ($paginator->hasPages())
    <nav class="mse2_pagination">
        <div class="paginator">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="age-item page-prev" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link" aria-hidden="true"></span>
                    </li>
                @else
                    <li class="age-item page-prev">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"></a>
                    </li>
                @endif
                {{-- Pagination Elements --}}
                <div class="pagination__content">

                    <?php
                    $start = $paginator->currentPage() - 2; // show 3 pagination links before current
                    $end = $paginator->currentPage() + 2; // show 3 pagination links after current
                    if ($start < 1) {
                        $start = 1; // reset start to 1
                        $end += 1;
                    }
                    if ($end >= $paginator->lastPage()) $end = $paginator->lastPage(); // reset end to last page
                    ?>

                    @for ($i = $start; $i <= $end; $i++)
                        <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                            <a class="page-link" href="{{ $paginator->url($i) }}">{{$i}}</a>
                        </li>
                    @endfor
                </div>

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item page-next">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"></a>
                    </li>
                @else
                    <li class="page-item page-next" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link" aria-hidden="true">&rsaquo;</span>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
@endif
