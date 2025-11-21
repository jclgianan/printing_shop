<div id="editUserModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <span id="closeEditUserModal" class="modal-close">&times;</span>

        <h3>Edit User</h3>

        <form id="editUserForm" method="POST">
            @csrf

            <div class="form-group">
                <label>Name</label>
                <input type="text" id="edit_user_name" name="name" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" id="edit_user_email" name="email" required>
            </div>

            <div class="form-group">
                <label>Role</label>
                <select id="edit_user_role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="editor">Editor</option>
                </select>
            </div>

            <hr>

            <div class="form-group">
                <label>New Password (optional)</label>
                <input type="password" name="password">
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation">
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>

    </div>
</div>
