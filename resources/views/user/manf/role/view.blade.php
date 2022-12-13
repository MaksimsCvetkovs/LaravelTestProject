@php
    $title = $role->name;
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <h1>{{ $title }}</h1>
    </div>

    <div class="border">
        <a class="btn btn-primary" href="{{ route('user.manf.role.user.add.list', ['manfId' => $manf->id, 'roleId' => $role->id]) }}">@lang("manf.role.user.add")</a>

        <div class="list-unstyled">
        @foreach ($paginator->items() as $index => $user)
        @include("user.item", ["canDeleteInRole" => true])
        @endforeach
        </div>

        @include("paginator")
    </div>
@endsection