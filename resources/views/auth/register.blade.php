<div id="registerModal" class="register-modal">
    <div class="registerModal-content">
        <span class="close">&times;</span>
                
        <div class="login-logo">
            <img src="{{ asset('images/Capitol_Logo.png') }}" alt="Logo" class="logo-image">
        </div>

        <h1 class="form-title">Register Page</h1>

        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-success">
                {{ session()->get('error') }}
            </div>
        @endif
        <div class="register-form">
            {{-- Display validation error messages if form submission fails. --}}
            {{--  This will show all errors in a red alert box at the top of the modal/form.--}}
            @if ($errors->any()) 
                <div class="alert alert-danger">
                    <ul style="margin: 0; padding-left: 1rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li> {{-- Output each error message --}}
                        @endforeach
                    </ul>
                </div>
            @endif 
            <form action="{{ route('register.post') }}" method="POST">
                @csrf

                <div class="register-group">
                    <label class="register-label" for="register-fullname">Full Name:</label>
                    <input class="register-input" type="text" id="register-fullname" name="fullname" value="{{ old('fullname') }}" required>
                </div>

                <div class="register-group">
                    <label class="register-label" for="register-email">Email:</label>
                    <input class="register-input" type="email" id="register-email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="register-group">
                    <label class="register-label" for="register-password">Password:</label>
                    <input class="register-input" type="password" id="register-password" name="password" required>
                </div>

                <div class="register-group">
                    <label class="register-label" for="register-confirm-password">Confirm Password:</label>
                    <input class="register-input" type="password" id="register-confirm-password" name="password_confirmation" required>
                </div>

                <div class="register-group">
                    <button class="signup-button" type="submit" id="signup-button">Sign up</button>
                </div>
            </form>
        </div>
    </div>
</div>
