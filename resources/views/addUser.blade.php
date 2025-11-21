@extends('layouts.default')

@section('title', 'User Management')

@section('content')
<div class="layout-wrapper">
    <main class="receiving-main-panel">

        <h2>User Management</h2>

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
                    <th>Edit</th>
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
                        <button class="btn-edit-user"
                            data-id="{{ $user->id }}"
                            data-name="{{ $user->name }}"
                            data-email="{{ $user->email }}"
                            data-role="{{ $user->role }}">
                            Edit
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button id="btnAddUser" class="btn btn-primary">
            Add User
        </button>

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