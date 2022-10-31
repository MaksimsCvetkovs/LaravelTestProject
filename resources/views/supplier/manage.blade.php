@php
    $user = auth()->user();
@endphp

@extends("layout")

@section("body")
    <div class="container">
        <h1>{{ $supplier->name }}</h1>

        <p>{{ $supplier->descr }}</p>

        <div class="card">
            <div class="card-header">
                Edit
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="edit">
                    <div class="mb-5">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ $supplier->name }}">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="descr" id="descr">{{ $supplier->descr }}</textarea>
                        </div>
                    </div>
                    <input class="btn btn-success" type="submit" value="Save">
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Users
            </div>
            <div class="card-body">
                <ul>
                @foreach ($supplier->userRoles as $userRole)
                    <li>{{ $userRole->name }}</li>
                    <ul>
                @foreach ($userRole->users as $supplierUser)
                        <li>{{ $supplierUser->user->name }}</li>
                @endforeach
                    </ul>
                @endforeach
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Delete
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="delete">
                    <input class="btn btn-danger" type="submit" value="Delete">
                </form>
            </div>
        </div>
    </div>
@endsection