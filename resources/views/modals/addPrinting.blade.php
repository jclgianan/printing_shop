<!-- resources/views/modals/addPrinting.blade.php -->
<div id="addPrintingModal" class="modal-overlay">
    <div class="modal-box">
        <span id="closeModal" class="modal-close"><i class="fa-regular fa-circle-xmark"></i></span>
        <div class="content-placeholder header-row-modal">
            <div class="header-top">
                <div class="header-text">
                    <h2>Add Printing Ticket</h2>
                </div>
            </div>
        </div>

        {{-- @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif --}}

        <div id="formMessage" style="display:none; margin-top:10px; padding:10px; border-radius:5px;"></div>

        <div class="content-placeholder-add-printing">
            <form id="printForm" class="process-form">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">

                <div class="form-group">
                    <label for="printTicket_id">Ticket ID</label>
                    <div class="idgen-container">
                        <input type="text" id="printTicket_id_display" class="form-control"
                            placeholder="Click 'Generate'" readonly disabled>
                        <input type="hidden" name="printTicket_id" id="printTicket_id" disabled>
                        <button type="button" onclick="generateprintTicketId()"
                            class="btn btn-secondary btn-generate-id">Generate <i class="fa-solid fa-gear"></i></button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="receiving_date">Receiving Date</label>
                    <input type="date" name="receiving_date" id="receiving_date"
                        class="form-control date-input @error('receiving_date') is-invalid @enderror"
                        value="{{ old('receiving_date') }}" required>
                    @error('receiving_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="office_department">Office/Department</label>
                    <input type="text" name="office_department" id="office_department"
                        class="form-control @error('office_department') is-invalid @enderror"
                        value="{{ old('office_department') }}" required>
                    @error('office_department')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="itemname">Name of Item</label>
                    <input type="text" name="itemname" id="itemname"
                        class="form-control @error('itemname') is-invalid @enderror" value="{{ old('itemname') }}"
                        required>
                    @error('itemname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="size">Size</label>
                    <input type="text" name="size" id="size"
                        class="form-control @error('size') is-invalid @enderror" value="{{ old('size') }}" required>
                    @error('size')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <div class="button-counter-container d-flex align-items-center">
                        <button class="minus-btn" type="button"><i class="fa-solid fa-minus fa-xs"></i></button>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                            id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1"
                            max="1000" required>
                        <button class="plus-btn" type="button"><i class="fa-solid fa-plus fa-xs"></i></button>
                    </div>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="deadline">Deadline</label>
                    <input type="date" name="deadline" id="deadline"
                        class="form-control @error('deadline') is-invalid @enderror" value="{{ old('deadline') }}">
                    @error('deadline')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="file_link">File</label>
                    <input type="text" name="file_link" id="file_link"
                        class="form-control @error('file_link') is-invalid @enderror" value="{{ old('file_link') }}">
                    @error('file_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <br>
                <button type="submit" class="submit-btn">Submit Ticket <i
                        class="fa-solid fa-paper-plane"></i></button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function generateprintTicketId() {
        const button = document.querySelector('.btn-generate-id');
        button.disabled = true;
        button.textContent = 'Generating...';

        fetch("{{ route('generate.printTicket.id') }}")
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.error) throw new Error(data.error);
                document.getElementById('printTicket_id_display').value = data.printTicket_id;
                document.getElementById('printTicket_id').value = data.printTicket_id;
                button.remove();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to generate ID. Please try again.');
                button.disabled = false;
                button.textContent = 'Generate';
            });
    }

    $(document).ready(function() {
        $(document).on('submit', '#printForm', function(e) {
            e.preventDefault();

            const form = $(this);
            const formData = form.serialize();
            const messageBox = $('#formMessage');
            const submitBtn = form.find('button[type="submit"]');
            submitBtn.prop('disabled', true).text('Submitting...');

            $.ajax({
                url: "{{ route('printTicket.store') }}",
                method: "POST",
                data: formData,
                success: function(response) {
                    if (response.success && response.ticket) {
                        Swal.fire({
                            title: 'Ticket updated successfully.',
                            icon: 'success',
                            customClass: {
                                container: "pop-up-success-container",
                                popup: "pop-up-success",
                                title: "pop-up-success-title",
                                htmlContainer: "pop-up-success-text",
                                confirmButton: "btn-normal",
                                icon: "pop-up-icon",
                            },
                            timer: 3000,
                            showConfirmButton: true
                        }).then(() => {
                            window.location.reload();
                        });
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
