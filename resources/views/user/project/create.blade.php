@extends("layout")

@section("body")
<div class="mt-5">
    <h1 class="h3 mb-3 font-height-normal text-center">Create Project</h1>

    <form method="POST" action="{{ route('user.project.create') }}" class="box" style="max-width: 300px; margin: 0 auto;">
        @csrf

        <div class="mb-2">
            <label for="name" class="form-label">@lang("validation.attributes.name")</label>
            <input class="form-control @error("name") is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" min="4" max="50">
        @error("name")
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        </div>

        <div class="mb-2">
            <label for="name" class="form-label">@lang("validation.attributes.descr")</label>
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

        <input class="btn btn-lg btn-primary w-100" type="submit" value="Create" custom-class="is-primary">
    </form>
</div>
@endsection