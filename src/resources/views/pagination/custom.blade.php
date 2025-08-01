@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- قبلی --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">قبلی</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">قبلی</a>
                </li>
            @endif

            {{-- شماره صفحات --}}
            @foreach ($elements as $element)
                {{-- Three Dots Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- بعدی --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">بعدی</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">بعدی</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
