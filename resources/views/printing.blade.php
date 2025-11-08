<!-- resources/views/prinitng.blade.php -->
@extends('layouts.default') {{-- Assuming this is your main layout --}}

@section('title', 'Receiving')

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
                    <a href="{{ route('printing.form', ['type' => 'addPrinting']) }}" class="receiving_newEntry">Create Ticket +</a>
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
                                        <a href="{{ route('process.edit', $ticket->id) }}" class="btn-edit">Edit</a>
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
@include('modals.select-type')
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
        const modal = document.getElementById('selectTypeModal');

        if (openBtn && closeBtn && modal) {
            // Open modal
            openBtn.addEventListener('click', () => {
                modal.classList.add('active');
            });

            // Close modal (clicking the close button)
            closeBtn.addEventListener('click', () => {
                modal.classList.remove('active');
            });

            // Close modal (clicking outside the modal)
            window.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('active');
                }
            });
        }
    });
</script>
@endpush
