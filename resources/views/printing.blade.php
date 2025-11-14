<!-- resources/views/prinitng.blade.php -->
@extends('layouts.default') {{-- Assuming this is your main layout --}}
@extends('auth.register')

@section('title', 'Printing')

@section('content')
<div class="receiving-container">
    <div class="layout-wrapper">
        <!-- Main Content Area -->
        <main class="receiving-main-panel">
            <!-- Header with New Entry button aligned to the right -->
            <div class="content-placeholder header-row">
                <div class="header-top">
                    <div class="header-text">
                        <h2 class="section-heading">Printing Dashboard</h2>
                        <p class="section-description">Select an option from the menu to get started.</p>
                    </div>
                    <!-- New Entry Button on the right -->
                    <a id="openModal" class="receiving_newEntry">Create Ticket +</a>
                </div>
            </div>
        
            <div class="logs-bottomBar">
                @php
                    $statusFilter = request('filter');
                @endphp
                <div class="category-filter">
                    <form action="{{ route('status-filter') }}" method="GET" class="filter-form">
                        <button class="filter-group {{ $statusFilter === null ? 'active' : '' }}" type="submit" name="filter" value="">All</button>
                        <button class="filter-group {{ $statusFilter === 'pending' ? 'active' : '' }}" type="submit" name="filter" value="pending">Pending</button>
                        <button class="filter-group {{ $statusFilter === 'in_progress' ? 'active' : '' }}" type="submit" name="filter" value="in_progress">In Progress</button>
                        <button class="filter-group {{ $statusFilter === 'printed' ? 'active' : '' }}" type="submit" name="filter" value="printed">Printed</button>
                        <button class="filter-group {{ $statusFilter === 'released' ? 'active' : '' }}" type="submit" name="filter" value="released">Released</button>
                        <button class="filter-group {{ $statusFilter === 'cancelled' ? 'active' : '' }}" type="submit" name="filter" value="cancelled">Cancelled</button>
                    </form>
                    <!-- Search Bar on the right -->
                    <form action="{{ route('receiving-search') }}" method="GET" class="search-form">
                        <div class="search-group">
                            <input type="text" name="query" class="search-input" placeholder="Search Ticket ID" aria-label="Search">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Table to display process logs -->
            <div class="process-log">
                @if(isset($printTickets) && count($printTickets) > 0)
                <table class="process-table">
                    <thead>
                        <tr class="table-header">
                            <th>Ticket ID</th>
                            <th>Receiving Date</th>
                            <th>Name</th>
                            <th>Office/Department</th>
                            <th>Name of Item</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Release Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($printTickets as $ticket)
                            <tr>
                                <td>{{ $ticket->printTicket_id }}</td>
                                <td>{{ \Carbon\Carbon::parse($ticket->receiving_date)->format('M j, Y') }}</td>
                                <td>{{ $ticket->name }}</td>
                                <td>{{ $ticket->office_department }}</td>
                                <td>{{ $ticket->itemname }}</td>
                                <td>{{ $ticket->size }}</td>
                                <td>{{ $ticket->quantity }}</td>
                                <td>{{ $ticket->status === 'released' ? \Carbon\Carbon::parse($ticket->release_date)->format('M j, Y') : '-' }}</td>
                                <td>
                                    <span class="status-badge status-{{ $ticket->status }}">{{ $ticket->formatted_status }}</span>
                                </td>
                                <td>
                                    <div class="action-buttons">                    
                                        @if($ticket->status === 'pending')
                                            <button onclick="updateStatus({{ $ticket->id }}, 'in_progress')" class="btn-status btn-progress">
                                                Start Progress
                                            </button>
                                        @endif
                                        
                                        @if($ticket->status === 'in_progress')
                                            <button onclick="updateStatus({{ $ticket->id }}, 'printed')" class="btn-status btn-complete">
                                                Mark Complete
                                            </button>
                                        @endif

                                        @if($ticket->status === 'printed')
                                            <button onclick="updateStatus({{ $ticket->id }}, 'released')" class="btn-status btn-released">
                                                Release
                                            </button>
                                        @endif
                                        
                                        @if($ticket->status !== 'cancelled' && $ticket->status !== 'printed' && $ticket->status !== 'released')
                                            <button onclick="updateStatus({{ $ticket->id }}, 'cancelled')" class="btn-status btn-cancel">
                                                Cancel
                                            </button>
                                        @endif
                                        <button class="btn-edit" 
                                                data-id="{{ $ticket->id }}"
                                                data-receiving_date="{{ $ticket->receiving_date }}"
                                                data-name="{{ $ticket->name }}"
                                                data-office_department="{{ $ticket->office_department }}"
                                                data-itemname="{{ $ticket->itemname }}"
                                                data-size="{{ $ticket->size }}"
                                                data-quantity="{{ $ticket->quantity }}"
                                                data-release_date="{{ $ticket->release_date ? \Carbon\Carbon::parse($ticket->release_date)->format('Y-m-d') : ''  }}">
                                            Edit
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <p>No processes available yet. Create a new entry to begin.</p>
                @endif
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
            body: JSON.stringify({ status: newStatus })
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

    document.addEventListener('DOMContentLoaded', function () {
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
    
    //For edit modal
    $(document).on('click', '.btn-edit', function() {
        const ticket = $(this).data();

        $('#edit_ticket_id').val(ticket.id);
        $('#edit_receiving_date').val(ticket.receiving_date);
        $('#edit_name').val(ticket.name);
        $('#edit_office_department').val(ticket.office_department);
        $('#edit_itemname').val(ticket.itemname);
        $('#edit_size').val(ticket.size);
        $('#edit_quantity').val(ticket.quantity);
        $('#edit_release_date').val(ticket.release_date);

        $('#editPrintingModal').show();
        $('#closeEditModal').on('click', function() {
            $('#editPrintingModal').hide();
        });

    });
    // Close edit modal when clicking outside the modal box
    $(document).on('click', '#editPrintingModal', function(e) {
        if ($(e.target).is('#editPrintingModal')) {
            $(this).hide();
        }
    });

    //Edit Modal submission
    $(document).on('submit', '#editPrintingForm', function(e) {
        e.preventDefault();

        const form = $(this);
        const formData = form.serialize();
        const messageBox = $('#editFormMessage');
        const submitBtn = form.find('button[type="submit"]');
        const ticketId = $('#edit_ticket_id').val();

        submitBtn.prop('disabled', true).text('Updating...');

        // Dynamically build the update URL
        let updateUrl = "{{ route('print.update', ':id') }}";
        updateUrl = updateUrl.replace(':id', ticketId);

        $.ajax({
            url: updateUrl,
            method: "POST",
            data: formData,
            success: function(response) {
                if (response.success) {
                    messageBox
                        .removeClass('alert-error')
                        .addClass('alert-box alert-success')
                        .text(response.success)
                        .fadeIn();

                    // Update the table row live without reloading
                    const row = $(`button[data-id='${ticketId}']`).closest('tr');
                    row.find('td:nth-child(3)').text(response.ticket.name);
                    row.find('td:nth-child(4)').text(response.ticket.office_department);
                    row.find('td:nth-child(5)').text(response.ticket.itemname);
                    row.find('td:nth-child(6)').text(response.ticket.size);
                    row.find('td:nth-child(7)').text(response.ticket.quantity);
                    row.find('td:nth-child(8)').text(response.ticket.release_date);

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
