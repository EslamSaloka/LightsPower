@if ($paginator->hasPages())
    <ul class="pagination mt-4 mb-0 float-end pagination-circled">
        <li class="page-item page-prev @if ($paginator->onFirstPage()) disabled @endif">
            <a class="page-link" href="{{$paginator->previousPageUrl()}}" tabindex="-1">@lang('Prev')</a>
        </li>
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <li class="page-item @if ($page == $paginator->currentPage()) active @endif"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endforeach
            @endif
        @endforeach
        <li class="page-item page-next @if (!$paginator->hasMorePages()) disabled @endif">
            <a class="page-link " href="{{$paginator->nextPageUrl()}}">@lang('Next')</a>
        </li>
    </ul> 
@endif
