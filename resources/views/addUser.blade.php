@extends('layouts.default')

@section('title', 'User Management')

@section('content')
<div class="layout-wrapper">
    <main class="receiving-main-panel">

        <div class="content-placeholder header-row">
            <div class="header-top">
                <div class="header-text">
                    <h2 class="section-heading"><i class="fa-solid fa-screwdriver-wrench"></i> User Management</h2>
                </div>
                <!-- Create Entry Button on the right -->
                @if(auth()->user()->role === 'admin')
                    <button id="btnAddUser" class="receiving_newEntry"><i class="fa-solid fa-file-circle-plus"></i> Add New User</button>
                @else
                    <button id="btnAddUser" class="disabled-button" disabled><i class="fa-solid fa-file-circle-plus"></i> Add New User</button>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>
                        @if(auth()->user()->role === 'admin')
                            <button class="btn-edit-user"
                                data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}"
                                data-role="{{ $user->role }}">
                                Edit
                            </button>
                        @else
                            <button class="btn-edit-user disabled-button" disabled>
                                Edit
                            </button>
                        @endif

                        @if(auth()->user()->role === 'admin')
                            <form action="{{ url('/users/delete/' . $user->id) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn-delete-user">Delete</button>
                            </form>
                        @else
                            <button class="btn-delete-user disabled-button" disabled>
                                Delete
                            </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </main>
</div>

@include('modals.edit-user')
@include('auth.register')

@endsection

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    // Edit modal
    $(document).ready(function() {

    // === Edit modal ===
        $(document).on('click', '.btn-edit-user', function () {
            let id = $(this).data('id');
            $('#editUserForm').attr('action', '/users/update/' + id);
            $('#edit_user_name').val($(this).data('name'));
            $('#edit_user_email').val($(this).data('email'));
            $('#edit_user_role').val($(this).data('role'));
            $('#editUserModal').fadeIn(200);
        });

        $('#closeEditUserModal').click(function () {
            $('#editUserModal').fadeOut(200);
        });

        // Optional: click outside to close edit modal
        $('#editUserModal').click(function(e) {
            if (e.target === this) $(this).fadeOut(200);
        });

        // === Register modal ===
        $('#btnAddUser').click(function() {
            $('#registerModal').fadeIn(200);
        });

        $('#closeRegisterModal').click(function() {
            $('#registerModal').fadeOut(200);
        });

        // Optional: click outside to close register modal
        $('#registerModal').click(function(e) {
            if (e.target === this) $(this).fadeOut(200);
        });

    });



</script>