@php
    if ($model->deleted) {
        $image = "/images/deleted.png";
    } else if ($model->hidden) {
        $image = "/images/hidden.png";
    } else {
        $image = "/images/test-2.png";
    }

    $imageWidth = "100px";
@endphp

<div class="d-flex m-2 p-2">
    <div class="flex-shrink-0">
        <img class="mr-3" src="{{ $image }}" alt="{{ $image }}" style="width: {{ $imageWidth }}">
    </div>
    <div class="flex-grow-1 ms-3">
    @if ($paginator->total() > 1)
        <h2>{{ ($paginator->currentPage() - 1) * $paginator->perPage() + $index + 1 }} / {{ $paginator->total() }}</h2>
    @endif
    @if ($model->deleted)
        <h4>@lang("model.deleted")</h4>
    @elseif ($model->hidden)
        <h4>@lang("model.hidden")</h4>
    @endif
    @if (!$model->deleted && (!$model->hidden || $user && $model->canEdit($user)))
        <h4>{{ $model->name }}</h4>
        <p>{{ $model->descr }}</p>
    @endif
    @isset ($canViewModel)
    <a class="btn btn-primary" href="{{ route('model.view', ['modelId' => $model->id]) }}">@lang("model.action.view")</a>
    @endif
    @isset ($canDeleteInProject)
        <a class="btn btn-danger" href="{{ route('user.project.model.delete', ['projectId' => $project->id, 'modelId' => $model->id]) }}">@lang("project.action.model-delete")</a>
    @endif
    </div>
</div>