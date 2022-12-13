@extends("layout")

@section("body")
    <div class="container">
        <form method="POST" action="{{ url()->current() }}" class="box" style="max-width: 300px; margin: 0 auto;">
            @csrf
    
            <div class="mb-2">
                <label for="name" class="form-label">@lang("validation.attributes.name")</label>
                <input class="form-control @error("name") is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" min="2" max="100">
                @error("name")
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="mb-2">
                <label for="can_edit" class="form-label">@lang("validation.attributes.can_edit")</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="can_edit" @if (old("can_edit")) checked @endif>
                </div>
            @error("can_edit")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>

            <input class="btn btn-primary" type="submit" value="@lang('manf.role.action.save')">
        </form>
    </div>
@endsection