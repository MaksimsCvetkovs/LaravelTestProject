@php
    $title = __("title.my-user");
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <h1>{{ $title }}</h1>

        <p>@lang("validation.attributes.name"): <strong>{{ $user->name }}</strong></p>
        <p>@lang("validation.attributes.email"): <strong>{{ $user->email }}</strong></p>
    </div>
@endsection