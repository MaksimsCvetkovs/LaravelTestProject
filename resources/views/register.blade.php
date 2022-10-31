@extends("layout")

@section("body")
<div class="container">
    <form method="POST" action="{{ route('register') }}" class="box">
        @csrf

        <div class="block">
            <input type="name" name="name" placeholder="Name">

            <input type="email" name="email" placeholder="Email">

            <input type="password" name="password" placeholder="Password" password-reveal>

            <input type="password" name="password_confirmation" placeholder="Password Confirmation">
        </div>

        <input type="submit" value="@lang('auth.register')" custom-class="is-primary">
    </form>
</div>
@endsection