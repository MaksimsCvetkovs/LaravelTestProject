@php
    $title = $manf->name;
    $user = auth()->user();
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <h1>{{ $title }}</h1>

        <p>{!! nl2br($manf->descr) !!}</p>

    @if ($user && $manf->canEdit($user))
        <a href="{{ route("user.manf.edit", ["manfId" => $manf->id]) }}" class="btn btn-success">@lang("manf.action.edit")</a>
        <a href="{{ route("user.manf.role.list", ["manfId" => $manf->id]) }}" class="btn btn-success">@lang("manf.roles.view")</a>
    @endif

        <div class="border">
            <div class="list-unstyled">
            @foreach ($paginator->items() as $index => $service)
                <div class="d-flex m-2 p-2">
                    <div class="flex-shrink-0">
                    @if ($service->deleted)
                        <img class="mr-3" src="/images/deleted.png" alt="/images/deleted.png" style="width: 100px">
                    @elseif ($service->hidden)
                        <img class="mr-3" src="/images/hidden.png" alt="/images/hidden.png" style="width: 100px">
                    @else
                        <img class="mr-3" src="/images/test-2.png" alt="/images/test-2.png" style="width: 100px">
                    @endif
                    </div>
                    <div class="flex-grow-1 ms-3">
                    @if ($service->deleted)
                        <h4>@lang("service.deleted")</h4>
                    @elseif ($service->hidden)
                        <h4>@lang("service.hidden")</h4>
                    @else
                        <h4>{{ $service->name }}</h4>
                        <p>{{ $service->descr }}</p>
                        <a class="btn btn-primary" href="{{ route('service.view', ['serviceId' => $service->id]) }}">@lang("service.action.view")</a>
                    @endif
                    </div>
                </div>
            @endforeach
            </div>

            @include("paginator")
        </div>
    </div>
@endsection