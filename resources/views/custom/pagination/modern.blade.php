@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="modern-pagination">
        <ul class="modern-pagination-list">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="modern-page-item nav-arrow disabled" aria-disabled="true">
                    <span class="modern-page-link">
                        <i class="bi bi-arrow-right"></i>
                    </span>
                </li>
            @else
                <li class="modern-page-item nav-arrow">
                    <a class="modern-page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="modern-page-item dots" aria-disabled="true">
                        <span class="modern-page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="modern-page-item active" aria-current="page">
                                <span class="modern-page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="modern-page-item">
                                <a class="modern-page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="modern-page-item nav-arrow">
                    <a class="modern-page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </li>
            @else
                <li class="modern-page-item nav-arrow disabled" aria-disabled="true">
                    <span class="modern-page-link">
                        <i class="bi bi-arrow-left"></i>
                    </span>
                </li>
            @endif
        </ul>

        <div class="modern-pagination-info">
            صفحة <strong>{{ $paginator->currentPage() }}</strong> من <strong>{{ $paginator->lastPage() }}</strong>
            @if($paginator->total() > 0)
                <span class="modern-pagination-divider">|</span>
                {{ number_format($paginator->total()) }} نتيجة
            @endif
        </div>
    </nav>
@endif
