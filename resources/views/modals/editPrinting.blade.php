<div id="editPrintingModal" class="modal-overlay">
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

        <div class="content-placeholder-edit-print">
            <form id="editPrintingForm" class="process-form">
                @csrf
                <div class="form-group">
                    <input type="hidden" id="edit_ticket_id" class="form-control" name="id">
                </div>

                <div class="form-group">
                    <label for="edit_name">Name</label>
                    <input type="text" id="edit_name" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_office_department">Office / Department</label>
                    <input type="text" id="edit_office_department" name="office_department" class="form-control" required>
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
                    <label for="edit-release_date">Release Date</label>
                    <input type="date" id="edit_release_date" name="release_date" class="form-control">
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Update Ticket</button>
            </form>
        </div>
    </div>
</div>
