@extends("layout")

@section("body")
    <div class="container">
        <form method="POST" action="{{ route('user.manf.create') }}" class="box" style="max-width: 300px; margin: 0 auto;">
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
                <label for="email" class="form-label">@lang("validation.attributes.email")</label>
                <input class="form-control @error("email") is-invalid @enderror" type="text" name="email" value="{{ old('email') }}">
                @error("email")
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <input class="btn btn-primary" type="submit" value="@lang('manf.action.save')">
        </form>
    </div>
@endsection