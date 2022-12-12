@php
    $title = __("title.manfs");
    $user = auth()->user();
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <h1>{{ $title }}</h1>

        <div class="list-unstyled">
        @foreach ($paginator->items() as $manf)
            <div class="border d-flex m-2 p-2">
                <div class="flex-shrink-0">
                    <img class="mr-3" src="/images/test-1.png" alt="/images/test-1.png" style="width: 150px">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h4>{{ $manf->name }}</h4>
                    <p>{{ $manf->descr }}</p>

                @if ($user && $manf->created_by == $user->id)
                    <a href="{{ route("manf.view", ["manfId" => $manf->id]) }}" class="btn btn-success">@lang("manf.action.edit")</a>
                @else
                    <a href="{{ route("manf.view", ["manfId" => $manf->id]) }}" class="btn btn-primary">@lang("manf.action.view")</a>
                @endif
                </div>
            </div>
        @endforeach
        </div>

        @include("paginator")
    </div>
@endsection