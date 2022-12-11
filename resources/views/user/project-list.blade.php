@php
    $user = auth()->user();
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <h1>My Projects</h1>

    @if ($user)
        <a href="{{ route('user.project.create') }}" class="btn btn-primary">Create</a>
    @endif

        <table class="table">
            <tbody>
            @foreach ($paginator->items() as $project)
                <tr>
                    <td>
                        <img src="/images/test-1.png" alt="images/test-1.png">
                    </td>
                    <td>{{ $project->name }}</td>
                    <td>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection