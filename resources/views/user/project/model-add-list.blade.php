@php
    $title = __("project.action.model-add");
    $user = auth()->user();
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <h1>{{ $title }}</h1>

        <div class="list-unstyled">
        @foreach ($paginator->items() as $model)
            <div class="border d-flex m-2 p-2">
                <div class="flex-shrink-0">
                    <img class="mr-3" src="/images/test-1.png" alt="/images/test-1.png" style="width: 150px">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h4>{{ $model->name }}</h4>
                    <p>{{ $model->descr }}</p>

                    <a href="{{ route("user.project.model.add", ['projectId' => $project->id, 'modelId' => $model->id]) }}" class="btn btn-primary">@lang("project.action.model-add")</a>
                    <a href="{{ route("model.view", ['modelId' => $model->id]) }}" class="btn btn-primary">@lang("model.action.view")</a>
                </div>
            </div>
        @endforeach
        </div>

        @include("paginator")
    </div>
@endsection