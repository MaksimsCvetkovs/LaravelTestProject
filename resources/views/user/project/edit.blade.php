@php
    $title = $project->name;
    $user = auth()->user();
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <form method="POST" action="{{ route('user.project.edit', ['projectId' => $project->id]) }}" class="box" style="max-width: 600px; margin: 0 auto;">
            @csrf
    
            <div class="mb-2">
                <label for="name" class="form-label">@lang("validation.attributes.name")</label>
                <input class="form-control @error("name") is-invalid @enderror" type="text" name="name" value="{{ old('name', $project->name) }}" min="4" max="50">
                @error("name")
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="mb-2">
                <label for="descr" class="form-label">@lang("validation.attributes.descr")</label>
                <textarea class="form-control @error("descr") is-invalid @enderror" name="descr" cols="30" rows="10">{{ old('descr', $project->descr) }}</textarea>
                @error("descr")
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="mb-2">
                <label for="hidden" class="form-label">@lang("validation.attributes.hidden")</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="hidden" @if (old("hidden", $project->hidden)) checked @endif>
                </div>
            @error("hidden")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>

            <input class="btn btn-primary" type="submit" value="@lang('project.action.save')">
        </form>

        <div class="border">
            <a class="btn btn-primary" href="{{ route('user.project.model.add.list', ['projectId' => $project->id]) }}">@lang("project.action.model-add")</a>

            <div class="list-unstyled">
            @foreach ($paginator->items() as $index => $model)
            @include("model.item", ["catViewModel" => true, "canDeleteInProject" => true])
            @endforeach
            </div>

            @include("paginator")
        </div>
    </div>
@endsection