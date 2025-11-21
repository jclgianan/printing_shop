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

        <div class="content-placeholder-edit-repair">
            <form id="editRepairForm" class="process-form">
                @csrf
                <div class="form-group">
                    <label for="repairDevice_id">Device ID</label>
                    <input type="text" name="repairDevice_id" id="edit_device_id" class="form-control" 
                        value="{{ $ticket->repairDevice_id ?? '' }}">
                </div>

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
                <button type="submit" class="btn btn-primary">Update Ticket</button>
            </form>
        </div>
    </div>
</div>

<script>
    $('#editRepairForm').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const formData = form.serialize();
        const messageBox = $('#editFormMessage');
        const submitBtn = form.find('button[type="submit"]');
        const ticketId = $('#edit_ticket_id').val(); // get ID from hidden input

        const updateUrl = `/repair/${ticketId}/update`; // matches your route

        submitBtn.prop('disabled', true).text('Updating...');

        $.ajax({
            url: updateUrl,
            method: "POST",
            data: formData,
            success: function(response) {
                messageBox
                    .removeClass('alert-error')
                    .addClass('alert-box alert-success')
                    .text(response.success)
                    .fadeIn();

                submitBtn.prop('disabled', false).text('Update Ticket');

                setTimeout(() => {
                    messageBox.fadeOut();
                    window.location.reload();
                    document.getElementById('editRepairModal').style.display = 'none';
                }, 1500);
            },
            error: function(xhr) {
                let message = 'Failed to update. Please try again.';
                if(xhr.responseJSON && xhr.responseJSON.details){
                    message += ' (' + xhr.responseJSON.details + ')';
                }
                messageBox
                    .removeClass('alert-success')
                    .addClass('alert-box alert-error')
                    .text(message)
                    .fadeIn();

                submitBtn.prop('disabled', false).text('Update Ticket');
            }
        });
    });

</script>


