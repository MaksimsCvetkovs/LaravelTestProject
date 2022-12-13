@php
    if ($printer->deleted) {
        $image = "/images/deleted.png";
    } else if ($printer->hidden) {
        $image = "/images/hidden.png";
    } else {
        $image = "/images/test-3.png";
    }

    $imageWidth = "100px";
@endphp
<div class="d-flex m-2 p-2">
    <div class="flex-shrink-0">
        <img class="mr-3" src="{{ $image }}" alt="{{ $image }}" style="width: {{ $imageWidth }}">
    </div>
    <div class="flex-grow-1 ms-3">
        <h4>{{ $printer->name }}</h4>
        <p>{{ $printer->descr }}</p>
        <p>{{ $printer->max_width }} x {{ $printer->max_height }} x {{ $printer->max_length }}</p>
        @isset ($canDeleteFromService)
        <a class="btn btn-primary" href="{{ route('user.service.edit.printer.delete', ['serviceId' => $service->id, 'printerId' => $printer->id]) }}">@lang("service.printer.action.delete")</a>
        @endif
    </div>
</div>