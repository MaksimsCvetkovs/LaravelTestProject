@php
    $title = $my ? __("title.my-models") : __("title.models");
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

    @if ($my)
        <a href="{{ route('user.model.create') }}" class="btn btn-primary">@lang("model.action.create")</a>
    @endif

        <div class="list-unstyled">
        @foreach ($paginator->items() as $model)
            <div class="border d-flex m-2 p-2">
                <div class="flex-shrink-0">
                    <img class="mr-3" src="/images/test-1.png" alt="/images/test-1.png" style="width: 150px">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h4>{{ $model->name }}</h4>
                    <p>{{ $model->descr }}</p>

                    <a href="{{ route("model.view", ["modelId" => $model->id]) }}" class="btn btn-primary">@lang("model.action.view")</a>
                </div>
            </div>
        @endforeach
        </div>

        @include("paginator")
    </div>
@endsection