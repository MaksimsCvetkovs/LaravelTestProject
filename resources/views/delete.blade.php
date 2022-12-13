@extends("layout")

@section("body")
    <div class="container text-center">
        <h1>{{ $message }}</h1>
        <form action="{{ url()->current() }}" method="POST">
            @csrf
            <input class="btn btn-danger" type="submit" value="{{ $deleteAction }}">
            <a class="btn btn-primary" href="{{ url()->previous() }}">{{ $cancelAction }}</a>
        </form>
    </div>
@endsection