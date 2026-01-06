<div id="editPrintingModal" class="modal-overlay">
    <div class="modal-box">
        <div class="header-row-modal">
            <div class="header-top-modal">
                <div class="header-text-modal">
                    <h2>Edit Printing Ticket</h2>
                </div>
            </div>
        </div>

        <div id="editFormMessage" style="display:none; margin-top:10px; padding:10px; border-radius:5px;"></div>

        <div class="container-modal">
            <div class="action-buttons" id="editActionBtn"></div>

            <form id="editPrintingForm" class="process-form">
                @csrf
                <input type="hidden" id="edit_ticket_id" name="id">

                <div class="form-group">
                    <label for="edit_name">Name</label>
                    <input type="text" id="edit_name" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_office_department">Office / Department</label>
                    <input type="text" id="edit_office_department" name="office_department" class="form-control"
                        required>
                </div>

                <div class="form-group">
                    <label for="edit_itemname">Item Name</label>
                    <input type="text" id="edit_itemname" name="itemname" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_size">Size</label>
                    <input type="text" id="edit_size" name="size" class="form-control">
                </div>

                <div class="form-group">
                    <label for="edit_quantity">Quantity</label>
                    <input type="number" id="edit_quantity" name="quantity" class="form-control">
                </div>

                <div class="form-group">
                    <label for="edit_deadline">Deadline</label>
                    <input type="date" id="edit_deadline" name="deadline" class="form-control">
                </div>

                <div class="form-group">
                    <label for="edit_file_link">File</label>
                    <input type="text" id="edit_file_link" name="file_link" class="form-control" placeholder="url">
                </div>

                <div class="form-group pb-2">
                    <label for="edit_release_date">Release Date</label>
                    <input type="date" id="edit_release_date" name="release_date" class="form-control">
                </div>
                <div class="formBtn">
                    <button type="button" id="closeEditModal" class="editBtn">Closwe</button>
                    <button type="submit" class="btn-normal">Save changes</button>
                </div>
            </form>

        </div>
    </div>
</div>
