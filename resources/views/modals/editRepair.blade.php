<!-- resources/views/modals/editPrinting.blade.php -->
<div id="editRepairModal" class="modal-overlay">
    <div class="modal-box">
        <div class="header-row-modal">
            <div class="header-top-modal">
                <div class="header-text-modal">
                    <h2>Edit Repair Ticket</h2>
                </div>
            </div>
        </div>

        <div id="editFormMessage" style="display:none; margin-top:10px; padding:10px; border-radius:5px;"></div>

        <div class="container-modal">

            <!-- Action buttons will be inserted here dynamically -->
            <div class="action-buttons" id="editActionBtn"></div>

            <form id="editRepairForm" class="process-form">
                @csrf
                <div class="form-group">
                    <label for="edit_device_id">Inventory ID</label>
                    <input type="text" name="inventory_id" id="edit_device_id" class="form-control"
                        value="{{ $ticket->inventory_id ?? '' }}">
                </div>

                <input type="hidden" name="ticket_id" id="edit_ticket_id">

                <div class="form-group">
                    <label for="edit_name">Name</label>
                    <input type="text" name="name" id="edit_name" class="form-control" autocomplete="name"
                        required>
                </div>

                <div class="form-group">
                    <label for="edit_office_department">Office/Department</label>
                    <input type="text" name="office_department" id="edit_office_department" class="form-control"
                        required>
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
                    <label for="edit_solution">Solution</label>
                    <input type="text" name="solution" id="edit_solution" class="form-control">
                </div>

                <div class="form-group">
                    <label for="edit_note">Note</label>
                    <input type="text" name="note" id="edit_note" class="form-control">
                </div>

                <div class="form-group">
                    <label for="edit_release_date">Release Date</label>
                    <input type="date" id="edit_release_date" name="release_date" class="form-control">
                </div>

                <br>
                <div class="formBtn">
                    <button type="button" id="closeEditModal" class="editBtn">Close</button>
                    <button type="submit" class="btn-normal">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
