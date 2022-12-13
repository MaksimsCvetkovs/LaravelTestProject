@php
    $title = $role->name;
@endphp

@extends("layout")

@section("body")
    <div class="list-unstyled">
    @foreach ($paginator->items() as $index => $user)
    @include("user.item", ["canAddUserInRole" => true])
    @endforeach
    </div>

    @include("paginator")
@endsection