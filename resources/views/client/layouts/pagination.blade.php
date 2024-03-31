<style>
    .custom-pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        padding: 0;
    }

    .pagination li {
        margin: 8px 5px;
    }

    .pagination li a,
    .pagination li span {
        display: block;
        padding: 4px 12px;
        text-decoration: none;
        color: #3490dc;
        border: 1px solid #3490dc;
        border-radius: 4px;
        font-size: 14px
    }

    .pagination li.active a {
        background-color: #3490dc;
        color: #fff;
    }

    .pagination li.disabled span {
        color: #a0aec0;
        cursor: not-allowed;
    }
</style>



            {{-- <div class="custom-pagination " style="margin-top: 24px">
                <ul class="pagination">
                    @if ($orders->onFirstPage())
                        <li class="disabled"><span><i class="fa-solid fa-angle-left"></i> Previous</span></li>
                    @else
                        <li><a href="{{ $orders->previousPageUrl() }}"><i class="fa-solid fa-angle-left"></i> Previous</a>
                        </li>
                    @endif

                    @foreach ($orders->links()->elements as $element)
                        @if (is_string($element))
                            <li class="disabled"><span>{{ $element }}</span></li>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                <li class="{{ $page == $orders->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                        @endif
                    @endforeach

                    @if ($orders->hasMorePages())
                        <li><a href="{{ $orders->nextPageUrl() }}">Next <i class="fa-solid fa-angle-right"></i></a></li>
                    @else
                        <li class="disabled"><span>Next <i class="fa-solid fa-angle-right"></i></span></li>
                    @endif
                </ul>
            </div> --}}