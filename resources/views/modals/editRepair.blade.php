<!-- resources/views/modals/editPrinting.blade.php -->
<div id="editRepairModal" class="modal-overlay">
    <div class="modal-box">
        <span id="closeEditModal" class="modal-close">&times;</span>
        <div class="content-placeholder header-row">
            <div class="header-top">
                <div class="header-text">
                    <h2>Edit Printing Ticket</h2>
                </div>
            </div>
        </div>

        <div id="editFormMessage" style="display:none; margin-top:10px; padding:10px; border-radius:5px;"></div>

        <div class="content-placeholder">
            <form id="editRepairForm" class="process-form">
                @csrf
                <input type="hidden" name="ticket_id" id="edit_ticket_id">

                <div class="form-group">
                    <label for="edit_name">Name</label>
                    <input type="text" name="name" id="edit_name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_office_department">Office/Department</label>
                    <input type="text" name="office_department" id="edit_office_department" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_itemname">Name of Item</label>
                    <input type="text" name="itemname" id="edit_itemname" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_issue">Issue</label>
                    <input type="text" name="issue" id="edit_issue" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_issue">Solution</label>
                    <input type="text" name="solution" id="edit_solution" class="form-control">
                </div>

                <div class="form-group">
                    <label for="edit_note">Note</label>
                    <input type="text" name="note" id="edit_note" class="form-control">
                </div>

                <div class="form-group">
                    <label for="edit-release_date">Release Date</label>
                    <input type="date" id="edit_release_date" name="release_date" class="form-control">
                </div>

                <br>
                <button type="submit" class="btn btn-primary">Update Ticket</button>
            </form>
        </div>
    </div>
</div>
