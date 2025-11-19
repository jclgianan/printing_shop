@extends("layouts.guest")


@section("title", "Login")

@section("login-content")
   
@endsection
<div class="login-page">
    <div class="login-container">
        <div class="login-logo">
            <img src="{{ asset('images/SecretShop_Logo2.png') }}" alt="Logo" class="logo-image">

        </div>

        <h1 class="form-title1">Welcome!</h1>
        <h1 class="form-title2">Please enter your credentials.</h1>

        @if(session()->has("success"))
            <div class="alert alert-success">
                {{ session()->get("success") }}
            </div>
        @endif
        @if(session()->has("error"))
            <div class="alert alert-success">
                {{ session()->get("error") }}
            </div>
        @endif
        <div class="login-form">
            <form action="{{ route("login.post") }}" method="POST">
                @csrf
                <div class="login-group">
                    {{-- <label class="login-label" for="email">Email:</label> --}}
                    <i class="asd fa-solid fa-envelope fa-xl"></i>
                    <input placeholder="Email" class="login-input" type="email" id="email" name="email">
                </div>
                <div class="login-group">
                    {{-- <label class="login-label" for="password">Password:</label> --}}
                    <i class="asd fa-solid fa-lock fa-xl"></i>
                    <input placeholder="Password" class="login-input" type="password" id="password" name="password">
                </div>
                <div class="login-group">
                    <button  class="login-button" type="submit"><i class="fa-solid fa-right-to-bracket fa-sm"></i>LOGIN</button>
                </div>
            </form>
        </div>
    </div>
</div>
