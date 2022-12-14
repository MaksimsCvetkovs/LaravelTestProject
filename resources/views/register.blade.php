@php
    $title = __("auth.register");
@endphp

@extends("layout")

@section("body")
<div class="mt-5">
    <h1 class="h3 mb-3 font-height-normal text-center">{{ $title }}</h1>

    <form method="POST" action="{{ route('register') }}" class="box" style="max-width: 300px; margin: 0 auto;">
        @csrf

        <div class="mb-2">
            <label for="name" class="form-label">@lang("validation.attributes.name")</label>
            <input class="form-control" type="name" name="name" value="{{ old('name') }}">
            @error("name")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2">
            <label for="email" class="form-label">@lang("validation.attributes.email")</label>
            <input class="form-control" type="email" name="email" value="{{ old('email') }}">
            @error("email")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2">
            <label for="name" class="form-label">@lang("validation.attributes.password")</label>
            <input class="form-control" type="password" name="password" password-reveal>
            @error("password")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2">
            <label for="name" class="form-label">@lang("validation.attributes.password_confirmation")</label>
            <input class="form-control" type="password" name="password_confirmation" password-reveal>
            @error("password_confirmation")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @error("default")
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <input class="btn btn-lg btn-primary w-100" type="submit" value="@lang('auth.action.register')">
    </form>
</div>
@endsection