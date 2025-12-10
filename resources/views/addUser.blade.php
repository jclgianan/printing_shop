@extends('layouts.default')

@section('title', 'User Management')

@section('content')
    <div class="layout-wrapper-adduser">
        <main class="receiving-main-panel">

            <div class="content-placeholder header-row">
                <div class="header-top">
                    <div class="header-text">
                        <h2 class="section-heading"><i class="fa-solid fa-screwdriver-wrench"></i> User Management</h2>
                    </div>
                    <!-- Create Entry Button on the right -->
                    @if (auth()->user()->role === 'admin')
                        <button id="btnAddUser" class="receiving_newEntry"><i class="fa-solid fa-file-circle-plus"></i> Add New
                            User</button>
                    @else
                        <button id="btnAddUser" class="disabled-button" disabled><i
                                class="fa-solid fa-file-circle-plus"></i> Add New User</button>
                    @endif
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="user-accounts-table">
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
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>
                                @if (auth()->user()->role === 'admin')
                                    <button id="userEdit" class="btn-edit-user" data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                        data-role="{{ $user->role }}">
                                        Edit
                                    </button>
                                @else
                                    <button class="btn-edit-user disabled-button" disabled>
                                        Edit
                                    </button>
                                @endif

                                @if (auth()->user()->role === 'admin')
                                    <form action="{{ url('/users/delete/' . $user->id) }}" method="POST"
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
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Register modal elements
            const addUserBtn = document.getElementById('btnAddUser');
            const registerModal = document.getElementById('registerModal');

            // Edit modal elements
            const editButtons = document.querySelectorAll('.btn-edit-user');
            const editModal = document.getElementById('editUserModal');

            // OPEN REGISTER MODAL
            if (addUserBtn && registerModal) {
                addUserBtn.addEventListener('click', () => {
                    registerModal.classList.add('active');
                });
            }

            // OPEN EDIT MODAL
            editButtons.forEach(btn => {
                btn.addEventListener('click', function () {

                    // Fill modal fields
                    let id = this.dataset.id;
                    document.getElementById('editUserForm').action = '/users/update/' + id;

                    document.getElementById('edit_user_name').value = this.dataset.name;
                    document.getElementById('edit_user_email').value = this.dataset.email;
                    document.getElementById('edit_user_role').value = this.dataset.role;

                    // Show modal
                    editModal.classList.add('active');
                });
            });

            // CLICK OUTSIDE TO CLOSE MODALS
            window.addEventListener('click', (e) => {
                if (e.target === registerModal) registerModal.classList.remove('active');
                if (e.target === editModal) editModal.classList.remove('active');
            });

        });
    </script>
@endpush