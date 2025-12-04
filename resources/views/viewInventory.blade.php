@extends('layouts.default')

@section('title', 'Device Units')

@section('content')
    <div class="receiving-container">
        <div class="layout-wrapper">
            <main class="receiving-main-panel">
                <!-- Breadcrumb Header -->
                <div class="inv-header-wrapper">
                    <div class="inv-header-left">
                        <a href="{{ route('inventory') }}" class="inv-back-link">&laquo; Inventory Management</a>
                        <h1 class="inv-title">{{ $items->first()->device_name }} — Units</h1>
                        <small class="inv-device-id">Device ID: {{ $deviceId }}</small>
                    </div>
                    <div class="inv-header-right">
                        <a href="{{ route('inventory.create') }}" class="inv-add-unit">+ Add Unit</a>
                    </div>
                </div>
                <div class="inv-row mb-4">
                    <div class="inv-card">
                        <h3>{{ $items->count() }}</h3>
                        <small>Total Units</small>
                    </div>
                    <div class="inv-card">
                        <h3>{{ $items->where('status','available')->count() }}</h3>
                        <small>Available</small>
                    </div>
                    <div class="inv-card">
                        <h3>{{ $items->where('status','issued')->count() }}</h3>
                        <small>Issued</small>
                    </div>
                    <div class="inv-card">
                        <h3>{{ $items->where('status','unusable')->count() }}</h3>
                        <small>Unusable</small>
                    </div>
                </div>
                <div class="process-log">
                    <table class="process-table">
                        <thead>
                            <tr class="table-header">
                                <th>Unique ID</th>
                                <th>Status</th>
                                <th>Condition</th>
                                <th>Assigned To</th>
                                <th>Office</th>
                                <th>Date Issued</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td>{{ $item->individual_id }}</td>
                                    <td>
                                        @if($item->status === 'available')
                                            <span class="inv-badge inv-status-available">Available</span>
                                        @elseif($item->status === 'issued')
                                            <span class="inv-badge inv-status-issued">Issued</span>
                                        @elseif($item->status === 'unusable')
                                            <span class="inv-badge inv-status-unusable">Unusable</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($item->condition === 'new')
                                            <span class="inv-badge inv-new">New</span>
                                        @elseif($item->condition === 'good')
                                            <span class="inv-badge inv-good">Good</span>
                                        @elseif($item->condition === 'fair')
                                            <span class="inv-badge inv-fair">Fair</span>
                                        @elseif($item->condition === 'poor')
                                            <span class="inv-badge inv-poor">Poor</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->issued_to ?? '—' }}</td>
                                    <td>{{ $item->office ?? '—' }}</td>
                                    <td>{{ $item->date_issued ? $item->date_issued->format('M d, Y') : '—' }}</td>
                                    <td>
                                        <!-- View Units Modal Trigger -->
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $item->id }}">
                                            View Units
                                        </button>

                                        <form action="" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete all units of this device?')">
                                                Delete All
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @include('modals.viewDetails', ['item' => $item])

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No units found for this device.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
            </main>
        </div>
    </div>
@endsection
