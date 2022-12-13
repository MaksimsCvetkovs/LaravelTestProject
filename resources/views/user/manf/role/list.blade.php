@php
    $title = $manf->name;
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <div class="border">
            <a class="btn btn-primary" href="{{ route('user.manf.role.create', ['manfId' => $manf->id]) }}">@lang("manf.role.action.create")</a>

            <div class="list-unstyled">
            @foreach ($paginator->items() as $index => $role)
                <div class="d-flex m-2 p-2">
                    <div class="flex-shrink-0">
                        <img class="mr-3" src="/images/test-2.png" alt="/images/test-2.png" style="width: 100px">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h4>{{ $role->name }}</h4>
                        <p>{{ $role->descr }}</p>
                        <a class="btn btn-primary" href="{{ route('user.manf.role.view', ['manfId' => $manf->id, 'roleId' => $role->id]) }}">@lang("manf.role.action.view")</a>
                        <a class="btn btn-primary" href="{{ route('user.manf.role.edit', ['manfId' => $manf->id, 'roleId' => $role->id]) }}">@lang("manf.role.action.edit")</a>
                        <a class="btn btn-danger" href="{{ route('user.manf.role.delete', ['manfId' => $manf->id, 'roleId' => $role->id]) }}">@lang("manf.role.action.delete")</a>
                    </div>
                </div>
            @endforeach
            </div>

            @include("paginator")
        </div>
    </div>
@endsection