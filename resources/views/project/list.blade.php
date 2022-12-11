@extends("layout")

@section("body")
    <div class="container">
        <h1>Public Projects</h1>

        <div class="list-unstyled">
        @foreach ($paginator->items() as $project)
            <div class="d-flex m-4">
                <div class="flex-shrink-0">
                    <img class="mr-3" src="/images/test-1.png" alt="/images/test-1.png" style="width: 150px">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h4>{{ $project->name }}</h4>
                    <p>{{ $project->descr }}</p>
                </div>
            </div>
        @endforeach
        </div>

    @if ($paginator->hasPages())
        <ul class="pagination">
            <li class="page-item">
                <a href="#" class="page-link">Prev</a>
                <a href="#" class="page-link">1</a>
                <a href="#" class="page-link">2</a>
                <a href="#" class="page-link">3</a>
                <a href="#" class="page-link">Next</a>
            </li>
        </ul>
    @endif
    </div>
@endsection