@php
    $title = $service->name;
    $user = auth()->user();
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <form method="POST" action="{{ route('user.service.edit', ['serviceId' => $service->id]) }}" class="box" style="max-width: 600px; margin: 0 auto;">
            @csrf
    
            <div class="mb-2">
                <label for="name" class="form-label">@lang("validation.attributes.name")</label>
                <input class="form-control @error("name") is-invalid @enderror" type="text" name="name" value="{{ old('name', $service->name) }}" min="4" max="50">
                @error("name")
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="mb-2">
                <label for="descr" class="form-label">@lang("validation.attributes.descr")</label>
                <textarea class="form-control @error("descr") is-invalid @enderror" name="descr" cols="30" rows="10">{{ old('descr', $service->descr) }}</textarea>
                @error("descr")
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <input class="btn btn-primary" type="submit" value="@lang('service.action.save')">
        </form>

        <div class="border">
            <div class="list-unstyled">
            {{--@foreach ($paginator->items() as $index => $model)
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
            @endforeach--}}
            </div>
        </div>
    </div>
@endsection