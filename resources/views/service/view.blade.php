@php
    $title = "Service $service->name";
    $user = auth()->user();
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <h1>{{ $title }}</h1>

        <p>{{ $service->descr }}</p>

        <div class="border">
            <div class="list-unstyled">
            @foreach ($paginator->items() as $printer)
                <div class="d-flex m-2 p-2">
                    <div class="flex-shrink-0">
                        <img class="mr-3" src="/images/test-2.png" alt="/images/test-2.png" style="width: 100px">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h4>{{ $printer->name }}</h4>
                        <p>{{ $printer->descr }}</p>
                        <p>{{ $printer->max_width }} x {{ $printer->max_height }} x {{ $printer->max_length }}</p>
                    </div>
                </div>
            @endforeach
            </div>

            @include("paginator")
        </div>
    </div>
@endsection