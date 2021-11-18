@if ($paginator->hasPages())
    <ul class="pagination ml-0 rl-0">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
            {{-- <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li> --}}
            <form method="POST" action="/calendar/page/{{$paginator->currentPage() - 1}}">
                {{ csrf_field() }}
                <input type="hidden" name="page" value="{{ $paginator->currentPage() - 1 }}">
            <li class="page-item"><button type="submit" class="page-link">&laquo;</button></li>
            </form>
        @endif
 

        {{-- Pagination Elements --}}
        @foreach ($elements as $key => $element)
        @php
            // dd($elements);
        @endphp
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @elseif($page == $paginator->currentPage() - 1 || $page == $paginator->currentPage() + 1 && count($element) != 2 )

                        @if ($paginator->currentPage() == $paginator->lastPage() && $key != 0)
                            <form method="POST" action="/calendar/page/{{$page - 1}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="page" value="{{ $page - 1 }}">
                                <li class="page-item"><button type="submit" class="page-link">{{ $page - 1 }}</button></li>
                            </form>
                        @endif

                        <form method="POST" action="/calendar/page/{{$page}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="page" value="{{ $page }}">
                            <li class="page-item"><button type="submit" class="page-link">{{ $page }}</button></li>
                        </form>
                        @if ($paginator->currentPage() == 1 && count($element) > 6)
                            @php
                                $page = 3;
                            @endphp
                            <form method="POST" action="/calendar/page/{{$page}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="page" value="{{ $page }}">
                                <li class="page-item"><button type="submit" class="page-link">{{ $page }}</button></li>
                            </form>
                        @endif
                        
                    @elseif(count($element) == 2)
                        <form method="POST" action="/calendar/page/{{$page}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="page" value="{{ $page }}">
                            <li class="page-item"><button type="submit" class="page-link">{{ $page }}</button></li>
                        </form>
                    @elseif(count($element) < 7)
                        <form method="POST" action="/calendar/page/{{$page}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="page" value="{{ $page }}">
                            <li class="page-item"><button type="submit" class="page-link">{{ $page }}</button></li>
                        </form>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            {{-- <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li> --}}
            <form method="POST" action="/calendar/page/{{$paginator->currentPage() + 1}}">
                {{ csrf_field() }}
                <input type="hidden" name="page" value="{{ $paginator->currentPage() + 1 }}">
                <li class="page-item"><button type="submit" class="page-link">&raquo;</button></li>
            </form>
        @else
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif
    </ul>
@endif
