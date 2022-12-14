@php
    $title = __("title.manfs");
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