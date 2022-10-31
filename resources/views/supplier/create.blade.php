@php
    $title = "Create New Supplier";
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <h1>{{ $title }}</h1>

        <form action="" method="POST">
            @csrf
            <input class="form-control" type="text" name="name" placeholder="Name">
            <textarea class="form-control" name="descr" placeholder="Description"></textarea>
            <input class="btn btn-success" type="submit" value="Create">
        </form>
    </div>
@endsection