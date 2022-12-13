@php
    $title = $manf->name;
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <form method="POST" action="{{ route('user.manf.edit', ['manfId' => $manf->id]) }}" class="box" style="max-width: 600px; margin: 0 auto;">
            @csrf
    
            <div class="mb-2">
                <label for="name" class="form-label">@lang("validation.attributes.name")</label>
                <input class="form-control @error("name") is-invalid @enderror" type="text" name="name" value="{{ old('name', $manf->name) }}" min="4" max="50">
                @error("name")
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="mb-2">
                <label for="descr" class="form-label">@lang("validation.attributes.descr")</label>
                <textarea class="form-control @error("descr") is-invalid @enderror" name="descr" cols="30" rows="10">{{ old('descr', $manf->descr) }}</textarea>
                @error("descr")
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="mb-2">
                <label for="email" class="form-label">@lang("validation.attributes.email")</label>
                <input class="form-control @error("email") is-invalid @enderror" type="text" name="email" value="{{ old('email', $manf->email) }}">
                @error("email")
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <input class="btn btn-primary" type="submit" value="@lang('manf.action.save')">
        </form>

        <div class="border">
            <a class="btn btn-primary" href="{{ route('user.service.create', ['manfId' => $manf->id]) }}">@lang("service.action.create")</a>

            <div class="list-unstyled">
            @foreach ($paginator->items() as $index => $service)
                <div class="d-flex m-2 p-2">
                    <div class="flex-shrink-0">
                        <img class="mr-3" src="/images/test-2.png" alt="/images/test-2.png" style="width: 100px">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h4>{{ $service->name }}</h4>
                        <p>{{ $service->descr }}</p>
                        <a class="btn btn-primary" href="{{ route('service.view', ['serviceId' => $service->id]) }}">@lang("service.action.view")</a>
                        <a class="btn btn-primary" href="{{ route('user.service.edit', ['serviceId' => $service->id]) }}">@lang("service.action.edit")</a>
                        <a class="btn btn-danger" href="{{ route('user.service.delete', ['serviceId' => $service->id]) }}">@lang("service.action.delete")</a>
                    </div>
                </div>
            @endforeach
            </div>

            @include("paginator")
        </div>
    </div>
@endsection