@php
    $title = __("auth.login");
@endphp

@extends("layout")

@section("body")
<div class="mt-5">
    <h1 class="h3 mb-3 font-height-normal text-center">{{ $title }}</h1>

    <form method="POST" action="{{ route('login') }}" class="box" style="max-width: 300px; margin: 0 auto;">
        @csrf

        <div class="mb-2">
            <label for="email" class="form-label">@lang("validation.attributes.email")</label>
            <input class="form-control" type="email" name="email" placeholder="Email">
            @error("email")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2">
            <label for="name" class="form-label">@lang("validation.attributes.password")</label>
            <input class="form-control" type="password" name="password" placeholder="Password" password-reveal>
            @error("password")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <input class="btn btn-lg btn-primary w-100" type="submit" value="@lang('auth.action.login')" custom-class="is-primary">
    </form>
</div>
@endsection