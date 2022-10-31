@php
    $title = __("auth.login");
@endphp

@extends("layout")

@section("body")
<div class="text-center mt-5">
    <h1 class="h3 mb-3 font-height-normal">{{ $title }}</h1>

    <form method="POST" action="{{ route('login') }}" class="box" style="max-width: 300px; margin: 0 auto;">
        @csrf

        <div class="mb-5">
            <input class="form-control" type="email" name="email" placeholder="Email">

            <input class="form-control" type="password" name="password" placeholder="Password" password-reveal>
        </div>

        <input class="btn btn-lg btn-primary w-100" type="submit" value="{{ $title }}" custom-class="is-primary">
    </form>
</div>
@endsection