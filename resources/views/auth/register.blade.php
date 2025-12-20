<div id="registerModal" class="modal-overlay">
    <div class="modal-box">
        {{-- <span id="closeModal" class="modal-close"><i class="fa-regular fa-circle-xmark"></i></span> --}}
        {{-- <div class="login-logo">
            <img src="{{ asset('images/Capitol_Logo.png') }}" alt="Logo" class="logo-image">
        </div> --}}
        <div class="content-placeholder header-row-modal">
            <div class="header-top">
                <div class="header-text">
                    <h2>Add User</h2>
                </div>
            </div>
        </div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="process-form">

            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>User Role</label>
                    <select name="role" required>
                        <option value="admin">Admin</option>
                        <option value="editor" selected>Editor</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="label" for="register-fullname">Full Name:</label>
                    <input class="form-control" type="text" id="register-fullname" name="fullname"
                        value="{{ old('fullname') }}" required>
                </div>

                <div class="form-group">
                    <label class="label" for="register-email">Email:</label>
                    <input class="form-control" type="email" id="register-email" name="email"
                        value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label class="label" for="register-password">Password:</label>
                    <input class="form-control" type="password" id="register-password" name="password" required>
                </div>

                <div class="form-group">
                    <label class="label" for="register-confirm-password">Confirm Password:</label>
                    <input class="form-control" type="password" id="register-confirm-password"
                        name="password_confirmation" required>
                </div>

                <div class="form-group">
                    <button class="submit-btn" type="submit">Add User</button>
                </div>

            </form>

        </div>
    </div>
</div>
