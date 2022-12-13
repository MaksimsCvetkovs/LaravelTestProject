@php
    $title = $model->name;
    $user = auth()->user();
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <h1>{{ $title }}</h1>

        <p>{!! nl2br($model->descr) !!}</p>

        <p>@lang("model.dimensions", ["width" => $model->width, "height" => $model->height, "length" => $model->length])</p>

    @if ($user && $model->canEdit($user))
        <a href="{{ route("user.model.edit", ["modelId" => $model->id]) }}" class="btn btn-success">@lang("model.action.edit")</a>
        <a href="{{ route("user.model.delete", ["modelId" => $model->id]) }}" class="btn btn-danger">@lang("model.action.delete")</a>
    @endif
    </div>
@endsection