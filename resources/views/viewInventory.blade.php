@extends('layouts.default')

@section('title', 'Device Units')

@section('content')
<div class="receiving-container">
    <div class="layout-wrapper">
        <main class="receiving-main-panel">
            <!-- Header with Back Button -->
            <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                <div>
                    <a href="{{ route('inventory') }}" class="btn btn-link text-decoration-none ps-0">
                        &laquo; Back
                    </a>
                    <h1 class="mb-0">{{ $items->first()->device_name }} — Units</h1>
                    <small class="text-muted">Device ID: {{ $deviceId }}</small>
                </div>
                <a href="{{ route('inventory.create') }}" class="btn btn-primary">
                    + Add Unit
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <h3 class="mb-0">{{ $items->count() }}</h3>
                            <small class="text-muted">Total Units</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h3 class="mb-0 text-success">{{ $items->where('status', 'available')->count() }}</h3>
                            <small class="text-muted">Available</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <h3 class="mb-0 text-info">{{ $items->where('status', 'issued')->count() }}</h3>
                            <small class="text-muted">Issued</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-danger">
                        <div class="card-body text-center">
                            <h3 class="mb-0 text-danger">{{ $items->where('status', 'damaged')->count() }}</h3>
                            <small class="text-muted">Damaged</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Units Table -->
            <div class="process-log">
                <div class="card-body">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Unique ID</th>
                                <th>Specifications</th>
                                <th>Status</th>
                                <th>Condition</th>
                                <th>Assigned To</th>
                                <th>Office</th>
                                <th>Date Acquired</th>
                                <th style="width: 220px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td><strong>{{ $item->individual_id }}</strong></td>

                                    <!-- Specifications Column -->
                                    <td>
                                        @if($item->processor || $item->ram || $item->storage || $item->graphics_card)
                                            <small>
                                                @if($item->processor)
                                                    <strong>CPU:</strong> {{ $item->processor }}<br>
                                                @endif
                                                @if($item->ram)
                                                    <strong>RAM:</strong> {{ $item->ram }}<br>
                                                @endif
                                                @if($item->storage)
                                                    <strong>Storage:</strong> {{ $item->storage }}<br>
                                                @endif
                                                @if($item->graphics_card)
                                                    <strong>GPU:</strong> {{ $item->graphics_card }}
                                                @endif
                                            </small>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        @if($item->status === 'available')
                                            <span class="badge bg-success">Available</span>
                                        @elseif($item->status === 'issued')
                                            <span class="badge bg-primary">Issued</span>
                                        @elseif($item->status === 'damaged')
                                            <span class="badge bg-danger">Damaged</span>
                                        @elseif($item->status === 'maintenance')
                                            <span class="badge bg-warning">Maintenance</span>
                                        @elseif($item->status === 'retired')
                                            <span class="badge bg-secondary">Retired</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($item->condition === 'new')
                                            <span class="badge bg-info">New</span>
                                        @elseif($item->condition === 'good')
                                            <span class="badge bg-success">Good</span>
                                        @elseif($item->condition === 'fair')
                                            <span class="badge bg-warning">Fair</span>
                                        @elseif($item->condition === 'poor')
                                            <span class="badge bg-danger">Poor</span>
                                        @endif
                                    </td>

                                    <td>{{ $item->issued_to ?? '—' }}</td>
                                    
                                    <td>{{ $item->office ?? '—' }}</td>

                                    <td>{{ $item->date_acquired ? $item->date_acquired->format('M d, Y') : '—' }}</td>

                                    <td>
                                        <!-- View Details Button -->
                                        <button type="button" 
                                                class="btn btn-sm btn-info" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#detailsModal{{ $item->id }}">
                                            <i class="bi bi-eye"></i> View
                                        </button>

                                        <!-- Edit Button -->
                                        <a href="" 
                                        class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="" 
                                            method="POST" 
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete this unit?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Details Modal -->
                                <div class="modal fade" id="detailsModal{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Device Details - {{ $item->individual_id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <strong>Device Name:</strong><br>
                                                        {{ $item->device_name }}
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <strong>Category:</strong><br>
                                                        {{ $item->category }}
                                                    </div>
                                                </div>

                                                @if($item->processor || $item->ram || $item->storage || $item->graphics_card)
                                                    <hr>
                                                    <h6 class="mb-3">Specifications</h6>
                                                    <div class="row">
                                                        @if($item->processor)
                                                            <div class="col-md-6 mb-2">
                                                                <strong>Processor:</strong> {{ $item->processor }}
                                                            </div>
                                                        @endif
                                                        @if($item->ram)
                                                            <div class="col-md-6 mb-2">
                                                                <strong>RAM:</strong> {{ $item->ram }}
                                                            </div>
                                                        @endif
                                                        @if($item->storage)
                                                            <div class="col-md-6 mb-2">
                                                                <strong>Storage:</strong> {{ $item->storage }}
                                                            </div>
                                                        @endif
                                                        @if($item->graphics_card)
                                                            <div class="col-md-6 mb-2">
                                                                <strong>Graphics Card:</strong> {{ $item->graphics_card }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @if($item->other_specs)
                                                        <div class="mt-2">
                                                            <strong>Other Specs:</strong><br>
                                                            {{ $item->other_specs }}
                                                        </div>
                                                    @endif
                                                @endif

                                                <hr>
                                                <h6 class="mb-3">Status Information</h6>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <strong>Status:</strong> 
                                                        <span class="badge bg-{{ $item->status === 'available' ? 'success' : ($item->status === 'issued' ? 'primary' : 'danger') }}">
                                                            {{ ucfirst($item->status) }}
                                                        </span>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <strong>Condition:</strong> 
                                                        <span class="badge bg-{{ $item->condition === 'new' ? 'info' : ($item->condition === 'good' ? 'success' : 'warning') }}">
                                                            {{ ucfirst($item->condition) }}
                                                        </span>
                                                    </div>
                                                </div>

                                                @if($item->issued_to || $item->office)
                                                    <hr>
                                                    <h6 class="mb-3">Assignment Information</h6>
                                                    <div class="row">
                                                        @if($item->issued_to)
                                                            <div class="col-md-6 mb-2">
                                                                <strong>Issued To:</strong> {{ $item->issued_to }}
                                                            </div>
                                                        @endif
                                                        @if($item->office)
                                                            <div class="col-md-6 mb-2">
                                                                <strong>Office:</strong> {{ $item->office }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif

                                                <hr>
                                                <h6 class="mb-3">Dates</h6>
                                                <div class="row">
                                                    @if($item->date_acquired)
                                                        <div class="col-md-4 mb-2">
                                                            <strong>Date Acquired:</strong><br>
                                                            {{ $item->date_acquired->format('M d, Y') }}
                                                        </div>
                                                    @endif
                                                    @if($item->date_issued)
                                                        <div class="col-md-4 mb-2">
                                                            <strong>Date Issued:</strong><br>
                                                            {{ $item->date_issued->format('M d, Y') }}
                                                        </div>
                                                    @endif
                                                    @if($item->warranty_expiration)
                                                        <div class="col-md-4 mb-2">
                                                            <strong>Warranty Expires:</strong><br>
                                                            {{ $item->warranty_expiration->format('M d, Y') }}
                                                            @if($item->isWarrantyValid())
                                                                <span class="badge bg-success">Valid</span>
                                                            @elseif($item->isWarrantyValid() === false)
                                                                <span class="badge bg-danger">Expired</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>

                                                @if($item->notes)
                                                    <hr>
                                                    <h6 class="mb-2">Notes</h6>
                                                    <p class="mb-0">{{ $item->notes }}</p>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <a href="" class="btn btn-warning">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        No units found for this device.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection