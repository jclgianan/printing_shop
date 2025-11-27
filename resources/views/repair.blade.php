<!-- resources/views/receiving.blade.php -->
@extends('layouts.default') {{-- Assuming this is your main layout --}}

@section('title', 'Repair')

@section('content')
<div class="receiving-container">
    <div class="layout-wrapper-repair">
        <!-- Main Content Area -->
        <main class="receiving-main-panel">
            <!-- Header with New Entry button aligned to the right -->
            <div class="content-placeholder header-row">
                <div class="header-top">
                    <div class="header-text">
                        <h2 class="section-heading"><i class="fa-solid fa-screwdriver-wrench"></i> Repair Tickets</h2>
                    </div>
                    <!-- Create Entry Button on the right -->
                    <a id="openModal" class="receiving_newEntry"><i class="fa-solid fa-file-circle-plus"></i> Create Ticket</a>
                </div>
            </div>
        
            <div class="logs-bottomBar">
                @php
                    $statusRepairFilter = request('filter');
                @endphp
                <div class="category-filter">
                    <form action="{{ route('status-repair-filter') }}" method="GET" class="filter-form">
                        <button class="filter-group {{ $statusRepairFilter === null ? 'active' : '' }}" type="submit" name="filter" value="">All</button>
                        <button class="filter-group {{ $statusRepairFilter === 'pending' ? 'active' : '' }}" type="submit" name="filter" value="pending">Pending</button>
                        <button class="filter-group {{ $statusRepairFilter === 'in_progress' ? 'active' : '' }}" type="submit" name="filter" value="in_progress">In Progress</button>
                        <button class="filter-group {{ $statusRepairFilter === 'repaired' ? 'active' : '' }}" type="submit" name="filter" value="repaired">Repaired</button>
                        <button class="filter-group {{ $statusRepairFilter === 'released' ? 'active' : '' }}" type="submit" name="filter" value="released">Released</button>
                        <button class="filter-group {{ $statusRepairFilter === 'unrepairable' ? 'active' : '' }}" type="submit" name="filter" value="unrepairable">Unrepairable</button>
                    </form>
                    <!-- Search Bar on the right -->
                    <form action="{{ route('repair-search') }}" method="GET" class="search-form">
                        <div class="search-group">
                            <input type="text" name="query" class="search-input" placeholder="Search Ticket ID" aria-label="Search">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Table to display repair logs -->
            <div class="process-log">
                @if(isset($repairTickets) && count($repairTickets) > 0)
                <table class="process-table">
                    <div class="thead-container">

                        <thead>
                            <tr class="table-header">
                                <th>Device ID</th>
                                <th>Ticket ID</th>
                                <th id="sortColumn" style="cursor:pointer;">Receiving Date<span id="sortArrow"></span></th>
                                <th>Name</th>
                                <th>Office</th>
                                <th>Name of Item</th>
                                <th>Issue</th>
                                <th>Solution</th>
                                <th>Note</th>
                                <th>Release Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </div>
                    <tbody>
                        @foreach($repairTickets as $ticket)
                            <tr>
                                <td>{{ $ticket->repairDevice_id }}</td>
                                <td>{{ $ticket->repairTicket_id }}</td>
                                <td>{{ \Carbon\Carbon::parse($ticket->receiving_date)->format('m/d/y') }}</td>
                                <td>{{ $ticket->name }}</td>
                                <td>{{ $ticket->office_department }}</td>
                                <td>{{ $ticket->itemname }}</td>
                                <td>{{ $ticket->issue }}</td>
                                <td>{{ $ticket->solution }}</td>
                                <td>{{ $ticket->note }}</td>
                                <td>{{ $ticket->status === 'released' ? \Carbon\Carbon::parse($ticket->release_date)->format('m/d/y H:i') : '-' }}</td>
                                <td>
                                    <span class="status-badge status-{{ $ticket->status }}">{{ $ticket->formatted_status }}</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-edit" 
                                                data-device_id="{{ $ticket->repairDevice_id }}"
                                                data-id="{{ $ticket->id }}"
                                                data-receiving_date="{{ $ticket->receiving_date }}"
                                                data-name="{{ $ticket->name }}"
                                                data-office_department="{{ $ticket->office_department }}"
                                                data-itemname="{{ $ticket->itemname }}"
                                                data-issue="{{ $ticket->issue }}"
                                                data-solution="{{ $ticket->solution }}"
                                                data-note="{{ $ticket->note }}"
                                                data-release_date="{{ $ticket->release_date ? \Carbon\Carbon::parse($ticket->release_date)->format('Y-m-d') : ''  }}"
                                                data-status="{{ $ticket->status }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
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
@include('modals.addRepair')

@include('modals.editRepair')

@endsection

@push('scripts')
<script>
    function updateStatus(ticketId, newStatus) {
        if (!confirm('Are you sure you want to change the status?')) {
            return;
        }

        fetch(`/repair-tickets/${ticketId}/status`, {
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
        const modal = document.getElementById('addRepairModal');

        if (openBtn && closeBtn && modal) {
            openBtn.addEventListener('click', () => modal.classList.add('active'));
            closeBtn.addEventListener('click', () => modal.classList.remove('active'));
            window.addEventListener('click', (e) => {
                if (e.target === modal) modal.classList.remove('active');
            });
        }
    });

    //Edit modal
     $(document).on('click', '.btn-edit', function() {
        const ticket = $(this).data();

        $('#edit_device_id').val(ticket.device_id || '');
        $('#edit_ticket_id').val(ticket.id);
        $('#edit_receiving_date').val(ticket.receiving_date);
        $('#edit_name').val(ticket.name);
        $('#edit_office_department').val(ticket.office_department);
        $('#edit_itemname').val(ticket.itemname);
        $('#edit_issue').val(ticket.issue);
        $('#edit_solution').val(ticket.solution);
        $('#edit_note').val(ticket.note);
        $('#edit_release_date').val(ticket.release_date);

        // Populate action buttons dynamically
        const actionContainer = $('#editActionBtn');
        actionContainer.empty(); // clear previous buttons

        if (ticket.status === 'pending') {
            actionContainer.append(`
                <button onclick="updateStatus(${ticket.id}, 'in_progress')" class="btn-status btn-progress">
                    Start Progress <i class="fa-solid fa-circle-play"></i>
                </button>
            `);
        }
        if (ticket.status === 'in_progress') {
            actionContainer.append(`
                <button onclick="updateStatus(${ticket.id}, 'repaired')" class="btn-status btn-complete">
                    Mark Complete <i class="fa-solid fa-circle-check"></i>
                </button>
            `);
        }
        if (ticket.status === 'repaired') {
            actionContainer.append(`
                <button onclick="updateStatus(${ticket.id}, 'released')" class="btn-status btn-released">
                    Release <i class="fa-solid fa-rocket"></i>
                </button>
            `);
        }
        if (ticket.status !== 'unrepairable' && ticket.status !== 'repaired' && ticket.status !== 'released') {
            actionContainer.append(`
                <button onclick="updateStatus(${ticket.id}, 'cancelled')" class="btn-status btn-cancel">
                    Unrepairable <i class="fa-solid fa-ban"></i>
                </button>
            `);
        }

        $('#editRepairModal').addClass('active');
        $('#closeEditModal').on('click', function() {
            $('#editRepairModal').removeClass('active');
        });
    });

    // Close edit modal when clicking outside the modal box
    $(document).on('click', '#editRepairModal', function(e) {
        if ($(e.target).is('#editRepairModal')) {
            $('#editRepairModal').removeClass('active');
        }
    });

    //Edit Modal submission
    $(document).on('submit', '#editRepairForm', function(e) {
        e.preventDefault();

        const form = $(this);
        const formData = form.serialize();
        const messageBox = $('#editFormMessage');
        const submitBtn = form.find('button[type="submit"]');
        const ticketId = $('#edit_ticket_id').val();

        submitBtn.prop('disabled', true).text('Updating...');

        // Dynamically build the update URL
        let updateUrl = "{{ route('repair.update', ':id') }}";
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
                    row.find('td:nth-child(3)').text(response.ticket.device_id);
                    row.find('td:nth-child(4)').text(response.ticket.name);
                    row.find('td:nth-child(5)').text(response.ticket.office_department);
                    row.find('td:nth-child(6)').text(response.ticket.itemname);
                    row.find('td:nth-child(7)').text(response.ticket.issue);
                    row.find('td:nth-child(8)').text(response.ticket.solution);
                    row.find('td:nth-child(9)').text(response.ticket.note);
                    row.find('td:nth-child(10)').text(response.ticket.release_date);

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

    //up down table sorting
    document.getElementById("sortColumn").addEventListener("click", function () {
        const tbody = document.querySelector("table tbody");
        const rows = Array.from(tbody.querySelectorAll("tr"));
        const arrow = document.getElementById("sortArrow");

        // Reverse rows
        rows.reverse();
        rows.forEach(r => tbody.appendChild(r));

        if (arrow.innerHTML === "" || arrow.textContent === "") {
            arrow.innerHTML = ""; 
        } else {
            arrow.innerHTML = ""; 
        }
    });



</script>
@endpush
