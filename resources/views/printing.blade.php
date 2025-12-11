<!-- resources/views/prinitng.blade.php -->
@extends('layouts.default') {{-- Assuming this is your main layout --}}

@section('title', 'Printing')

@section('content')
    <div class="receiving-container">
        <div class="layout-wrapper-printing">
            <!-- Main Content Area -->
            <main class="receiving-main-panel">
                <!-- Header with New Entry button aligned to the right -->
                <div class="content-placeholder header-row">
                    <div class="header-top">
                        <div class="header-text">
                            <h2 class="section-heading"><i class="fa-solid fa-print"></i> Printing Tickets</h2>
                        </div>
                        <!-- New Entry Button on the right -->
                        <a id="openModal" class="receiving_newEntry"><i class="fa-solid fa-file-circle-plus"></i> Create
                            Ticket</a>
                    </div>
                </div>

                <div class="logs-bottomBar">
                    @php
                        $statusFilter = request('filter');
                    @endphp
                    <div class="category-filter">
                        <form action="{{ route('status-filter') }}" method="GET" class="filter-form">
                            <button class="filter-group {{ $statusFilter === null ? 'active' : '' }}" type="submit"
                                name="filter" value="">All</button>
                            <button class="filter-group {{ $statusFilter === 'pending' ? 'active' : '' }}" type="submit"
                                name="filter" value="pending">Pending</button>
                            <button class="filter-group {{ $statusFilter === 'in_progress' ? 'active' : '' }}"
                                type="submit" name="filter" value="in_progress">Ongoing</button>
                            <button class="filter-group {{ $statusFilter === 'printed' ? 'active' : '' }}" type="submit"
                                name="filter" value="printed">Printed</button>
                            <button class="filter-group {{ $statusFilter === 'released' ? 'active' : '' }}" type="submit"
                                name="filter" value="released">Released</button>
                            <button class="filter-group {{ $statusFilter === 'cancelled' ? 'active' : '' }}" type="submit"
                                name="filter" value="cancelled">Cancelled</button>
                        </form>
                        <!-- Search Bar on the right -->
                        <form action="{{ route('receiving-search') }}" method="GET" class="search-form">
                            <div class="search-group">
                                <input type="text" name="query" class="search-input" placeholder="Search"
                                    aria-label="Search">
                                <button class="btn btn-primary" type="submit"><i
                                        class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Table to display process logs -->
                <div class="process-log">
                    @if (isset($printTickets) && count($printTickets) > 0)
                        <table class="process-table">
                            <thead>
                                <tr class="table-header">
                                    <th>Ticket ID</th>
                                    <th>Receiving Date</th>
                                    <th>Name</th>
                                    <th>Office</th>
                                    <th>Name of Item</th>
                                    <th>Size</th>
                                    <th>Quantity</th>
                                    <th>Deadline</th>
                                    <th class="file_link_td">File</th>
                                    <th>Release Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($printTickets as $ticket)
                                    <tr>
                                        <td class="mono">{{ $ticket->printTicket_id }}</td>
                                        <td class="mono">
                                            {{ \Carbon\Carbon::parse($ticket->receiving_date)->format('m/d/y') }}</td>
                                        <td>{{ $ticket->name }}</td>
                                        <td>{{ $ticket->office_department }}</td>
                                        <td>{{ $ticket->itemname }}</td>
                                        <td class="mono">{{ $ticket->size }}</td>
                                        <td class="mono">{{ $ticket->quantity }}</td>
                                        <td class="mono">
                                            {{ $ticket->deadline ? \Carbon\Carbon::parse($ticket->deadline)->timezone('Asia/Manila')->format('m/d/y') : '-' }}
                                        </td>
                                        <td class="file-icon">
                                            @if ($ticket->file_link)
                                                <a href="{{ $ticket->file_link }}" target="_blank">
                                                    <i class="fa-regular fa-file"></i></a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $ticket->release_date ? \Carbon\Carbon::parse($ticket->release_date)->timezone('Asia/Manila')->format('m/d/y, H:i') : '-' }}
                                        </td>

                                        <td>
                                            <span
                                                class="status-badge status-{{ $ticket->status }}">{{ $ticket->formatted_status }}</span>
                                        </td>
                                        <td>
                                            <button class="btn-edit" data-id="{{ $ticket->id }}"
                                                data-receiving_date="{{ $ticket->receiving_date }}"
                                                data-name="{{ $ticket->name }}"
                                                data-office_department="{{ $ticket->office_department }}"
                                                data-itemname="{{ $ticket->itemname }}" data-size="{{ $ticket->size }}"
                                                data-quantity="{{ $ticket->quantity }}"
                                                data-deadline="{{ $ticket->deadline ? \Carbon\Carbon::parse($ticket->deadline)->format('Y-m-d') : '' }}"
                                                data-file_link="{{ $ticket->file_link }}"
                                                data-release_date="{{ $ticket->release_date ? \Carbon\Carbon::parse($ticket->release_date)->format('Y-m-d\TH:i') : '' }}"
                                                data-status="{{ $ticket->status }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No processes available yet. Create a new entry to begin.</p>
                    @endif
                </div>
                <div class="custom-pagination">
                    {{ $printTickets->appends(request()->input())->links('pagination::bootstrap-5') }}
                </div>
            </main>
        </div>
    </div>
    @include('modals.addPrinting')

    @include('modals.editPrinting')

@endsection

@push('scripts')
    <script>
        function updateStatus(ticketId, newStatus) {
            if (!confirm('Are you sure you want to change the status?')) {
                return;
            }

            fetch(`/print-tickets/${ticketId}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload the page to show updated status
                        window.location.reload();
                    } else {
                        alert('Failed to update status. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the status.');
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const openBtn = document.getElementById('openModal');
            const closeBtn = document.getElementById('closeModal');
            const modal = document.getElementById('addPrintingModal');

            if (openBtn && closeBtn && modal) {
                openBtn.addEventListener('click', () => modal.classList.add('active'));
                closeBtn.addEventListener('click', () => modal.classList.remove('active'));
                window.addEventListener('click', (e) => {
                    if (e.target === modal) modal.classList.remove('active');
                });
            }
        });

        // For edit modal
        $(document).on('click', '.btn-edit', function() {
            const ticket = $(this).data();

            $('#edit_ticket_id').val(ticket.id);
            $('#edit_receiving_date').val(ticket.receiving_date);
            $('#edit_name').val(ticket.name);
            $('#edit_office_department').val(ticket.office_department);
            $('#edit_itemname').val(ticket.itemname);
            $('#edit_size').val(ticket.size);
            $('#edit_quantity').val(ticket.quantity);
            $('#edit_deadline').val(ticket.deadline);
            $('#edit_file_link').val(ticket.file_link);
            // FIX: Only set the DATE part for the date input, but store original datetime
            if (ticket.release_date) {
                // Extract just the date portion for the input (YYYY-MM-DD)
                let dateOnly = ticket.release_date.split(' ')[0].split('T')[0];
                $('#edit_release_date').val(dateOnly);

                // Store the FULL datetime in a hidden field or data attribute
                $('#edit_release_date').data('original-datetime', ticket.release_date);
            } else {
                $('#edit_release_date').val('');
                $('#edit_release_date').data('original-datetime', '');
            }

            // Populate action buttons dynamically
            const actionContainer = $('#editActionBtn');
            actionContainer.empty(); // clear previous buttons

            if (ticket.status === 'pending') {
                actionContainer.append(`
                <button onclick="updateStatus(${ticket.id}, 'in_progress')" class="btn-status btn-progress">
                    Start Progress <i class="fa-regular fa-circle-play"></i>
                </button>
            `);
            }
            if (ticket.status === 'in_progress') {
                actionContainer.append(`
                <button onclick="updateStatus(${ticket.id}, 'printed')" class="btn-status btn-complete">
                    Mark Complete <i class="fa-regular fa-circle-check"></i>
                </button>
            `);
            }
            if (ticket.status === 'printed') {
                actionContainer.append(`
                <button onclick="updateStatus(${ticket.id}, 'released')" class="btn-status btn-released">
                    Release <i class="fa-solid fa-rocket"></i>
                </button>
            `);
            }
            if (ticket.status !== 'cancelled' && ticket.status !== 'printed' && ticket.status !== 'released') {
                actionContainer.append(`
                <button onclick="updateStatus(${ticket.id}, 'cancelled')" class="btn-status btn-cancel">
                    Cancel <i class="fa-solid fa-ban"></i>
                </button>
            `);
            }

            $('#editPrintingModal').addClass('active');
        });

        //Close button
        $('#closeEditModal').off('click').on('click', function() {
            $('#editPrintingModal').removeClass('active');
        });

        // Close edit modal when clicking outside the modal box
        $(document).on('click', '#editPrintingModal', function(e) {
            if ($(e.target).is('#editPrintingModal')) {
                $('#editPrintingModal').removeClass('active');
            }
        });

        // Edit Modal submission - UPDATED to preserve datetime
        $(document).on('submit', '#editPrintingForm', function(e) {
            e.preventDefault();

            const form = $(this);
            const messageBox = $('#editFormMessage');
            const submitBtn = form.find('button[type="submit"]');
            const ticketId = $('#edit_ticket_id').val();

            // Get the original datetime
            const releaseDateInput = $('#edit_release_date');
            const originalDateTime = releaseDateInput.data('original-datetime');
            const newDate = releaseDateInput.val();

            // Build form data
            let formData = form.serializeArray();

            // If release_date wasn't changed, use original datetime
            if (originalDateTime && newDate) {
                const originalDate = originalDateTime.split(' ')[0].split('T')[0];

                if (newDate === originalDate) {
                    // Date unchanged - use full original datetime
                    formData = formData.filter(item => item.name !== 'release_date');
                    formData.push({
                        name: 'release_date',
                        value: originalDateTime
                    });
                }
                // If date was changed, the new date value from form will be used
            }

            submitBtn.prop('disabled', true).text('Updating...');

            let updateUrl = "{{ route('print.update', ':id') }}";
            updateUrl = updateUrl.replace(':id', ticketId);

            $.ajax({
                url: updateUrl,
                method: "POST",
                data: $.param(formData),
                success: function(response) {
                    if (response.success) {
                        messageBox
                            .removeClass('alert-error')
                            .addClass('alert-box alert-success')
                            .text(response.success)
                            .fadeIn();

                        submitBtn.prop('disabled', false).text('Update Ticket');

                        setTimeout(() => {
                            window.location.reload();
                        }, 800);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Failed to update. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    messageBox
                        .removeClass('alert-success')
                        .addClass('alert-box alert-error')
                        .text(errorMessage)
                        .fadeIn();

                    submitBtn.prop('disabled', false).text('Update Ticket');
                }
            });
        });
    </script>
@endpush
