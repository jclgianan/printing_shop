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
                    <label for="edit-deadline">Deadline</label>
                    <input type="date" id="edit_deadline" name="deadline" class="form-control">
                </div>

                <div class="form-group">
                    <label for="edit_file_link">File</label>
                    <input type="text" id="edit_file_link" name="file_link" class="form-control" placeholder="url">
                </div>

                <div class="form-group pb-2">
                    <label for="edit-release_date">Release Date</label>
                    <input type="date" id="edit_release_date" name="release_date" class="form-control">
                </div>
                {{-- <br> --}}
                <button type="submit" class="btn btn-primary ">Change info</button>
                @foreach($printTickets as $ticket)
                <div class="action-buttons">                    
                    @if($ticket->status === 'pending')
                        <button onclick="updateStatus({{ $ticket->id }}, 'in_progress')" class="btn-status btn-progress">
                            Start Progress <i class="fa-solid fa-circle-play"></i>
                        </button>
                    @endif
                    
                    @if($ticket->status === 'in_progress')
                        <button onclick="updateStatus({{ $ticket->id }}, 'printed')" class="btn-status btn-complete">
                            Mark Complete <i class="fa-solid fa-circle-check"></i>
                        </button>
                    @endif

                    @if($ticket->status === 'printed')
                        <button onclick="updateStatus({{ $ticket->id }}, 'released')" class="btn-status btn-released">
                            Release <i class="fa-solid fa-rocket"></i>
                        </button>
                    @endif
                    
                    @if($ticket->status !== 'cancelled' && $ticket->status !== 'printed' && $ticket->status !== 'released')
                        <button onclick="updateStatus({{ $ticket->id }}, 'cancelled')" class="btn-status btn-cancel">
                            Cancel <i class="fa-solid fa-ban"></i>
                        </button>
                    @endif
                </div> 
                @endforeach
            </form>
        </div>
    </div>
</div>
