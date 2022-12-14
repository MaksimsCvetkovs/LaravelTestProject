@php
    $title = __("title.services");
    $user = auth()->user();
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <h1 class="mb-4">{{ $title }}</h1>

        <div class="mb-4">
            <form action="{{ url()->current() }}" method="POST">
                @csrf
                <div class="input-group">
                    <input class="form-control" type="text" name="name_search" placeholder="@lang('validation.attributes.name')" value="{{ $nameSearch }}">
                    <div class="input-group-append">
                        <input class="btn btn-primary" type="submit" value="@lang('service.action.search')">
                    </div>
                </div>
            </form>
        </div>

        <div class="list-unstyled">
        @foreach ($paginator->items() as $service)
            <div class="border d-flex m-2 p-2">
                <div class="flex-shrink-0">
                    <img class="mr-3" src="/images/test-1.png" alt="/images/test-1.png" style="width: 150px">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h4>{{ $service->name }}</h4>
                    <p>@lang("service.manf-owned") <a href="{{ route('manf.view', ['manfId' => $service->manf_id]) }}">{{ $service->manf->name }}</a></p>
                    <p>{{ $service->descr }}</p>
                @if ($service->printers_count > 0)
                    <p>@lang("service.printers-count", ["count" => $service->printers_count])</p>
                @endif

                    <a href="{{ route("service.view", ["serviceId" => $service->id]) }}" class="btn btn-primary">@lang("service.action.view")</a>
                </div>
            </div>
        @endforeach
        </div>

        @include("paginator")
    </div>
@endsection