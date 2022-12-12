@php
    $title = __("title.services");
    $user = auth()->user();
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <h1>{{ $title }}</h1>

        <div class="list-unstyled">
        @foreach ($paginator->items() as $service)
            <div class="border d-flex m-2 p-2">
                <div class="flex-shrink-0">
                    <img class="mr-3" src="/images/test-1.png" alt="/images/test-1.png" style="width: 150px">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h4>{{ $service->name }}</h4>
                    <p>{{ $service->descr }}</p>
                @if ($service->printers_count > 0)
                    <p>@lang("service.printers-count", ["count" => $service->printers_count])</p>
                @endif

                @if ($user && $service->created_by == $user->id)
                    <a href="{{ route("service.view", ["serviceId" => $service->id]) }}" class="btn btn-success">@lang("service.action.edit")</a>
                @else
                    <a href="{{ route("service.view", ["serviceId" => $service->id]) }}" class="btn btn-primary">@lang("service.action.view")</a>
                @endif
                </div>
            </div>
        @endforeach
        </div>

        @include("paginator")
    </div>
@endsection