@php
    $title = __("title.my-manfs");
    $user = auth()->user();
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <h1>{{ $title }}</h1>

        <a href="{{ route('user.manf.create') }}" class="btn btn-primary">Create</a>

        <div class="list-unstyled">
        @foreach ($paginator->items() as $manf)
            <div class="border d-flex m-2 p-2">
                <div class="flex-shrink-0">
                    <img class="mr-3" src="/images/test-1.png" alt="/images/test-1.png" style="width: 150px">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h4>{{ $manf->name }}</h4>
                    <p>{{ $manf->descr }}</p>

                    <a href="{{ route("manf.view", ["manfId" => $manf->id]) }}" class="btn btn-primary">@lang("manf.action.view")</a>
                </div>
            </div>
        @endforeach
        </div>

        @include("paginator")
    </div>
@endsection