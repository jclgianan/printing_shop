<!-- resources/views/modals/addPrinting.blade.php -->
<div id="addRepairModal" class="modal-overlay">
    <div class="modal-box">
        <span id="closeModal" class="modal-close">&times;</span>
        <div class="content-placeholder header-row">
            <div class="header-top">
                <div class="header-text">
                    <h2>Add Repair Ticket</h2>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div id="formMessage" style="display:none; margin-top:10px; padding:10px; border-radius:5px;"></div>
        
        <div class="content-placeholder">
            <form id="repairForm"  class="process-form">
                @csrf
                <input type="hidden" name="type">

                <div class="form-group">
                    <label for="repairTicket_id">Ticket ID</label>
                    <div style="display: flex; gap: 10px;">
                        <input type="text" id="repairTicket_id_display" class="form-control" placeholder="Click 'Generate'" readonly>
                        <input type="hidden" name="repairTicket_id" id="repairTicket_id">
                        <button type="button" onclick="generaterepairTicketId()" class="btn btn-secondary btn-generate-id">Generate</button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="receiving_date">Receiving Date</label>
                    <input type="date" name="receiving_date" id="receiving_date" class="form-control @error('receiving_date') is-invalid @enderror" value="{{ old('receiving_date') }}" required>
                    @error('receiving_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="office_department">Office/Department</label>
                    <input type="text" name="office_department" id="office_department" class="form-control @error('office_department') is-invalid @enderror" value="{{ old('office_department') }}" required>
                    @error('office_department')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="itemname">Name of Item</label>
                    <input type="text" name="itemname" id="itemname" class="form-control @error('itemname') is-invalid @enderror" value="{{ old('itemname') }}" required>
                    @error('itemname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="issue">Issue</label>
                    <input type="text" name="issue" id="issue" class="form-control @error('size') is-invalid @enderror" value="{{ old('size') }}" required>
                    @error('size')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="note">Note</label>
                    <input type="text" name="note" id="note" class="form-control @error('note') is-invalid @enderror" value="{{ old('note') }}">
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <br>
                <button type="submit" class="btn btn-primary">Submit Ticket</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function generaterepairTicketId() {
        const button = document.querySelector('.btn-generate-id');
        button.disabled = true;
        button.textContent = 'Generating...';

        fetch("{{ route('generate.repairTicket.id') }}")
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.error) throw new Error(data.error);
                document.getElementById('repairTicket_id_display').value = data.repairTicket_id;
                document.getElementById('repairTicket_id').value = data.repairTicket_id;
                button.textContent = 'Generated';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to generate ID. Please try again.');
                button.disabled = false;
                button.textContent = 'Generate';
            });
    }

    $(document).ready(function() {
        $(document).on('submit', '#repairForm', function(e) {
            e.preventDefault();

            const form = $(this);
            const formData = form.serialize();
            const messageBox = $('#formMessage');
            const submitBtn = form.find('button[type="submit"]');
            submitBtn.prop('disabled', true).text('Submitting...');

            $.ajax({
                url: "{{ route('repairTicket.store') }}",
                method: "POST",
                data: formData,
                success: function(response) {
                    if (response.success && response.ticket) {
                        messageBox
                            .removeClass('alert-error')
                            .addClass('alert-box alert-success')
                            .text(response.success)
                            .fadeIn();

                        form[0].reset();
                        submitBtn.prop('disabled', false).text('Submit Ticket');

                        setTimeout(() => {
                            messageBox.fadeOut();
                            window.location.reload();
                            document.getElementById('addRepairModal').style.display = 'none';
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    messageBox
                        .removeClass('alert-success')
                        .addClass('alert-box alert-error')
                        .text('Failed to submit. Please try again.')
                        .fadeIn();

                    submitBtn.prop('disabled', false).text('Submit Ticket');
                }
            });
        });
    });

</script>

