@php
    $user = auth()->user();
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <h1>Suppliers</h1>

    @if ($user)
        <a href="{{ route('supplier.create') }}" class="btn btn-primary">Create</a>
    @endif

        <table class="table">
            <tbody>
            @foreach ($suppliers as $supplier)
                <tr>
                    <td>
                        <img src="images/test-1.png" alt="images/test-1.png">
                    </td>
                    <td>{{ $supplier->name }}</td>
                    <td>
                    @if ($supplier->canEdit($user))
                        <a href="{{ route('supplier.view', ['supplierId' => $supplier->id]) }}" class="btn btn-primary">Edit</a>
                    @else
                        <a href="{{ route('supplier.view', ['supplierId' => $supplier->id]) }}" class="btn btn-primary">View</a>
                    @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection