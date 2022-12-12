@php
    $title = $project->name;
    $user = auth()->user();
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <h1>{{ $title }}</h1>

        <p>{!! nl2br($project->descr) !!}</p>

    @if ($project->canEdit($user))
        <a href="{{ route("user.project.edit", ["projectId" => $project->id]) }}" class="btn btn-success">@lang("project.action.edit")</a>
    @endif

        <div class="border">
            <div class="list-unstyled">
            @foreach ($paginator->items() as $index => $model)
                <div class="d-flex m-2 p-2">
                    <div class="flex-shrink-0">
                        <img class="mr-3" src="/images/test-2.png" alt="/images/test-2.png" style="width: 100px">
                    </div>
                    <div class="flex-grow-1 ms-3">
                    @if ($paginator->total() > 1)
                        <h2>{{ ($paginator->currentPage() - 1) * $paginator->perPage() + $index + 1 }} / {{ $paginator->total() }}</h2>
                    @endif
                        <h4>{{ $model->name }}</h4>
                        <p>{{ $model->descr }}</p>
                    </div>
                </div>
            @endforeach
            </div>

            @include("paginator")
        </div>
    </div>
@endsection