@php
    $user = auth()->user();
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <h1>{{ $supplier->name }}</h1>

        <p>{{ $supplier->descr }}</p>

        @if ($user)
            
        @endif
    </div>
@endsection