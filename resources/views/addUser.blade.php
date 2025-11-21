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
    </main>
</div>

@include('modals.edit-user')

@endsection

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $(document).on('click', '.btn-edit-user', function () {
        let id = $(this).data('id');

        // Set form action
        $('#editUserForm').attr('action', '/users/update/' + id);

        // Fill fields
        $('#edit_user_name').val($(this).data('name'));
        $('#edit_user_email').val($(this).data('email'));
        $('#edit_user_role').val($(this).data('role'));

        // Show modal
        $('#editUserModal').show();
    });

    // Close modal
    $('#closeEditUserModal').click(function () {
        $('#editUserModal').hide();
    });


</script>