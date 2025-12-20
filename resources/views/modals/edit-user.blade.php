<div id="editUserModal" class="modal-overlay">
    <div class="modal-box">
        <span id="closeEditUserModal" class="modal-close">&times;</span>

        <h3>Edit User</h3>

        <form id="editUserForm" class="process-form" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="edit_user_name" name="name" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" id="edit_user_email" name="email" required>
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
                <input type="password" class="form-control" name="password">
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation">
            </div>

            <button type="submit" class="submit-btn">Save Changes</button>
        </form>

    </div>
</div>
