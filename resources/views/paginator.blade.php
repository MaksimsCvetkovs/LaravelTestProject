@if ($paginator->hasPages())
<ul class="pagination justify-content-center">
@if (!$paginator->onFirstPage())
    <li class="page-item">
        <a href="{{ $paginator->previousPageUrl() }}" class="page-link">Prev</a>
    </li>
@endif
@if ($paginator->currentPage() > 4)
<li class="page-item">
    <a href="{{ $paginator->url(1) }}" class="page-link">1</a>
</li>
@endif
@if ($paginator->currentPage() > 5)
<li class="page-item">
    <a class="page-link">...</a>
</li>
@endif
@for ($i = 0; $i < 3; $i++)
@php $page = $paginator->currentPage() - 3 + $i; @endphp
@if ($page >= 1)
    <li class="page-item">
        <a href="{{ $paginator->url($page) }}" class="page-link">{{ $page }}</a>
    </li>
@endif
@endfor
    <li class="page-item active">
        <a class="page-link">{{ $paginator->currentPage() }}</a>
    </li>
@for ($i = 0; $i < 3; $i++)
@php $page = $paginator->currentPage() + $i + 1; @endphp
@if ($page <= $paginator->lastPage())
    <li class="page-item">
        <a href="{{ $paginator->url($page) }}" class="page-link">{{ $page }}</a>
    </li>
@endif
@endfor
@if ($paginator->lastPage() - $paginator->currentPage() >= 5)
<li class="page-item">
    <a class="page-link">...</a>
</li>
@endif
@if ($paginator->lastPage() - $paginator->currentPage() >= 4)
<li class="page-item">
    <a href="{{ $paginator->url($paginator->lastPage()) }}" class="page-link">{{ $paginator->lastPage() }}</a>
</li>
@endif
@if (!$paginator->onLastPage())
    <li class="page-item">
        <a href="{{ $paginator->nextPageUrl() }}" class="page-link">Next</a>
    </li>
@endif
</ul>
@endif