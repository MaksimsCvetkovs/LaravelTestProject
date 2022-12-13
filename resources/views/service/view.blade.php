@php
    $title = "Service $service->name";
    $user = auth()->user();
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <h1>{{ $title }}</h1>

        <p>@lang("service.manf-owned") <a href="{{ route('manf.view', ['manfId' => $service->manf_id]) }}">{{ $service->manf->name }}</a></p>

        <p>{{ $service->descr }}</p>

        @if ($user && $service->canEdit($user))
            <a href="{{ route("user.service.edit", ["serviceId" => $service->id]) }}" class="btn btn-success">@lang("service.action.edit")</a>
        @endif

        <div class="border">
            <div class="list-unstyled">
            @foreach ($paginator->items() as $printer)
            @include("printer.item")
            @endforeach
            </div>

            @include("paginator")
        </div>
    </div>
@endsection