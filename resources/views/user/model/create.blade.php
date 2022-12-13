@php
    $title = __("model.action.creat");
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <form method="POST" action="{{ url()->current() }}" class="box" style="max-width: 300px; margin: 0 auto;">
            @csrf
    
            <div class="mb-2">
                <label for="name" class="form-label">@lang("validation.attributes.name")</label>
                <input class="form-control @error("name") is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" min="4" max="50">
            @error("name")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>
    
            <div class="mb-2">
                <label for="descr" class="form-label">@lang("validation.attributes.descr")</label>
                <textarea class="form-control @error("descr") is-invalid @enderror" name="descr" cols="30" rows="10">{{ old('descr') }}</textarea>
            @error("descr")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>
    
            <div class="mb-2">
                <label for="hidden" class="form-label">@lang("validation.attributes.hidden")</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="hidden" @if (old("hidden", true)) checked @endif>
                </div>
            @error("hidden")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>
    
            <div class="mb-2">
                <label for="width" class="form-label">@lang("validation.attributes.width")</label>
                <input class="form-control @error("width") is-invalid @enderror" type="number" step="0.01" name="width" value="{{ old('width') }}">
            @error("width")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>
    
            <div class="mb-2">
                <label for="height" class="form-label">@lang("validation.attributes.height")</label>
                <input class="form-control @error("height") is-invalid @enderror" type="number" step="0.01" name="height" value="{{ old('height') }}">
            @error("height")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>
    
            <div class="mb-2">
                <label for="length" class="form-label">@lang("validation.attributes.length")</label>
                <input class="form-control @error("length") is-invalid @enderror" type="number" step="0.01" name="length" value="{{ old('length') }}">
            @error("length")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>

            @error("default")
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <input class="btn btn-lg btn-primary w-100" type="submit" value="@lang('manf.action.create')">
        </form>
    </div>
@endsection