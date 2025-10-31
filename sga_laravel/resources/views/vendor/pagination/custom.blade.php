@if ($paginator->hasPages())
    <style>
        /* Estilo para a paginação */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination li a, .pagination li span {
            padding: 10px 15px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #007bff;
        }

        .pagination li.active span {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }

        .pagination li a:hover {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .pagination li.disabled span {
            color: #ccc;
            pointer-events: none;
            border: 1px solid #ddd;
        }
    </style>

    <ul class="pagination" role="navigation">
        @if ($paginator->onFirstPage())
            <li class="disabled" aria-disabled="true"><span>&laquo; Anterior</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; Anterior</a></li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Próximo &raquo;</a></li>
        @else
            <li class="disabled" aria-disabled="true"><span>Próximo &raquo;</span></li>
        @endif
    </ul>
@endif

