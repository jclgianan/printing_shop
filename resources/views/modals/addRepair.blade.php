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
        
        <div class="content-placeholder-add-repair">
            <form id="repairForm"  class="process-form">
                @csrf
                <input type="hidden" name="type">

                <div class="form-group">
                    <label>Do you have an existing Device ID?</label>
                    <div style="display: flex; gap: 15px; margin-bottom: 10px;">
                        <label><input type="radio" name="has_id" value="yes"> Yes</label>
                        <label><input type="radio" name="has_id" value="no"> No</label>
                    </div>
                </div>

                <div class="form-group" id="existingIdBox" style="display: none;">
                    <label for="repairTicket_id_manual">Enter Existing Device ID</label>
                    <input type="text" id="repairTicket_id_manual" class="form-control" placeholder="Enter ID">
                </div>

                <div class="form-group" id="generateIdBox" style="display: none;">
                    <label for="repairDevice_id">Device ID</label>
                    <div style="display: flex; gap: 10px;">
                        <input type="text" id="repairDevice_id_display" class="form-control" placeholder="Click 'Generate'" readonly>
                        <input type="hidden" name="repairDevice_id" id="repairDevice_id">
                        <button type="button" onclick="generaterepairDeviceId()" class="btn btn-secondary btn-generate-device-id">Generate</button>
                    </div>
                </div>

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
                    @error('issue')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="note">Note</label>
                    <input type="text" name="note" id="note" class="form-control @error('note') is-invalid @enderror" value="{{ old('note') }}">
                    @error('note')
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
    // Function for Device ID selection and generation
    function generaterepairDeviceId() {
        const button = document.querySelector('.btn-generate-device-id');
        button.disabled = true;
        button.textContent = 'Generating...';

        fetch("{{ route('generate.repairDevice.id') }}")
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.error) throw new Error(data.error);
                document.getElementById('repairDevice_id_display').value = data.repairDevice_id;
                document.getElementById('repairDevice_id').value = data.repairDevice_id;
                button.textContent = 'Generated';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to generate ID. Please try again.');
                button.disabled = false;
                button.textContent = 'Generate';
            });
    }

    // Show/hide input fields based on user selection
    document.querySelectorAll('input[name="has_id"]').forEach(radio => {
        radio.addEventListener('change', function () {
            const existingIdBox = document.getElementById('existingIdBox');
            const generateIdBox = document.getElementById('generateIdBox');

            if (this.value === "yes") {
                existingIdBox.style.display = "block";
                generateIdBox.style.display = "none";

                // Sync hidden input with manual Device ID
                const manualInput = document.getElementById('repairTicket_id_manual');
                document.getElementById('repairDevice_id').value = manualInput.value;

                // Update hidden input whenever user types
                manualInput.addEventListener('input', function() {
                    document.getElementById('repairDevice_id').value = this.value;
                });

            } else {
                existingIdBox.style.display = "none";
                generateIdBox.style.display = "block";

                // Clear hidden input so controller generates a new ID
                document.getElementById('repairDevice_id').value = '';
            }
        });
    });

    // Function for Repair Ticket Generation and Selection

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
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

    $('#repairForm').on('submit', function(e) {
        e.preventDefault();

        // Ensure hidden input is synced with manual input if "Yes" is selected
        if ($('input[name="has_id"]:checked').val() === 'yes') {
            $('#repairDevice_id').val($('#repairTicket_id_manual').val());
        }

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
                let message = 'Failed to submit. Please try again.';
                if(xhr.responseJSON && xhr.responseJSON.details){
                    message += ' (' + xhr.responseJSON.details + ')';
                }
                messageBox
                    .removeClass('alert-success')
                    .addClass('alert-box alert-error')
                    .text(message)
                    .fadeIn();

                submitBtn.prop('disabled', false).text('Submit Ticket');
            }
        });
    });


</script>

