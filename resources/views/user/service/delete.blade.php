@php
    $title = $service->name;
@endphp

@extends("layout")

@section("body")
    <div class="container text-center">
        <h1>@lang("service.message.delete")</h1>
        <form action="{{ route('user.service.delete', ['serviceId' => $service->id]) }}" method="POST">
            @csrf
            <input class="btn btn-danger" type="submit" value="@lang('service.action.delete')">
            <a class="btn btn-primary" href="{{ url()->previous() }}">@lang("service.action.cancel")</a>
        </form>
    </div>
@endsection