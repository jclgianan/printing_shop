<!-- resources/views/receiving.blade.php -->
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
                        <h2 class="section-heading">Receiving Dashboard</h2>
                        <p class="section-description">Select an option from the menu to get started.</p>
                    </div>
                    <!-- New Entry Button on the right -->
                    <button id="openModal" class="receiving_newEntry">New Entry +</button>
                </div>
            </div>
        
            <div class="logs-bottomBar">
                @php
                    $categoryFilter = request('filter');
                @endphp
                <div class="category-filter">
                    <form action="{{ route('category-filter') }}" method="GET" class="filter-form">
                        <button class="filter-group {{ $categoryFilter === null ? 'active' : '' }}" type="submit" name="filter" value="">All</button>
                        <button class="filter-group {{ $categoryFilter === 'category1' ? 'active' : '' }}" type="submit" name="filter" value="category1">Category 1</button>
                        <button class="filter-group {{ $categoryFilter === 'category2' ? 'active' : '' }}" type="submit" name="filter" value="category2">Category 2</button>
                        <button class="filter-group {{ $categoryFilter === 'category3' ? 'active' : '' }}" type="submit" name="filter" value="category3">Category 3</button>
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
                @if(count($processes) > 0)
                <table class="process-table">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Receiving Date</th>
                            <th>Name</th>
                            <th>Office/Department</th>
                            <th>Name of Item</th>
                            <th>Problem</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($processes as $process)
                            <tr>
                                <td>{{ $process->process_id }}</td>
                                <td>{{ \Carbon\Carbon::parse($process->receiving_date)->format('M j, Y') }}</td>
                                <td>{{ ucfirst($process->type) }}</td>
                                <td>{{ $process->category }}</td>
                                <td>{{ ucfirst($process->status) }}</td>
                                <td>
                                    <a href="{{ route('process.edit', $process->id) }}" class="btn-edit">Edit</a>
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
