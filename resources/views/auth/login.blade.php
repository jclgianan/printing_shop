@extends("layouts.guest")


@section("title", "Login")

@section("login-content")
   
@endsection
<div class="login-page">
    <div class="login-container">
        <div class="login-logo">
            <img src="{{ asset('images/Capitol_Logo.png') }}" alt="Logo" class="logo-image">
        </div>
        <h1 class="form-title">Login Page</h1>
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
                    <label class="login-label" for="email">Email:</label>
                    <input class="login-input" type="email" id="email" name="email">
                </div>
                <div class="login-group">
                    <label class="login-label" for="password">Password:</label>
                    <input class="login-input" type="password" id="password" name="password">
                </div>
                <div class="login-group">
                    <button class="login-button" type="submit">Login</button>
                </div>
                <div class="login-group">
                    <div class="login-signup">
                        <p>Don't have an account? <a href="{{ route('register') }}" class="signup-btn">Sign up</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include("auth.register")
@if ($errors->any())
    <script>
        // If there are validation errors (e.g. mismatched passwords),
        // reopen the register modal on page load and clear the password fields
        // so the user doesn't have to retype all their information.
        window.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('registerModal');
            if (modal) {
                modal.style.display = 'block';

                // Clear only password fields for security and clarity
                const passwordField = document.getElementById('register-password');
                const confirmPasswordField = document.getElementById('register-confirm-password');

                if (passwordField) passwordField.value = '';
                if (confirmPasswordField) confirmPasswordField.value = '';
            }
        });
    </script>
@endif

