@php
    $title = $project->name;
    $user = auth()->user();
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <h1>{{ $title }}</h1>

        <p>{!! nl2br($project->descr) !!}</p>

    @if ($user && $project->canEdit($user))
        <a href="{{ route("user.project.edit", ["projectId" => $project->id]) }}" class="btn btn-success">@lang("project.action.edit")</a>
        <a href="{{ route("user.project.delete", ["projectId" => $project->id]) }}" class="btn btn-danger">@lang("project.action.delete")</a>
    @endif

        <div class="border">
            <div class="list-unstyled">
            @foreach ($paginator->items() as $index => $model)
            @include("model.item", ["catViewModel" => true])
            @endforeach
            </div>

            @include("paginator")
        </div>
    </div>
@endsection