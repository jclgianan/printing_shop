@extends('layouts.default')

@section('title', 'Device Units')

@section('content')
    <div class="receiving-container">
        <div class="layout-wrapper">
            <main class="receiving-main-panel">
                <!-- Breadcrumb Header -->
                <a href="{{ route('inventory') }}" class="inv-back-link"><i class="fa-solid fa-arrow-left-long"></i> Return</a>
                <div class="inv-header-wrapper">
                    <div class="inv-header-left">
                        <h1 class="inv-title">{{ $items->first()->device_name }} — Units</h1>
                        <small class="inv-device-id">Device ID: {{ $deviceId }}</small>
                    </div>
                    <button type="button" class="inv-add-unit" data-bs-toggle="modal" data-bs-target="#addUnitModal">
                        + Add Unit
                    </button>
                </div>
                @if (session('success'))
                    <script>
                        window.onload = () => {

                            const successMessage = `{{ session('success') }}`;


                            Swal.fire({
                                title: successMessage || 'Device added successfully.',
                                icon: 'success',
                                customClass: {
                                    container: "pop-up-success-container",
                                    popup: "pop-up-success",
                                    title: "pop-up-success-title",
                                    htmlContainer: "pop-up-success-text",
                                    confirmButton: "btn-success",
                                    icon: "pop-up-icon",
                                },
                                timer: 3000,
                                showConfirmButton: true
                            }).then((result) => {
                                window.location.reload();
                            });
                        };
                    </script>
                @endif

                <div class="inv-row">
                    <div class="inv-card total-units">
                        <div class="card-units">
                            <div class="units-left">
                                <p>Total Units</p>
                                <h4 id="printing-pending">{{ $items->count() }}</h4>
                            </div>
                            <div class="units-right">
                                <i class="fa-solid fa-list-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="inv-card available-units">
                        <div class="card-units">
                            <div class="units-left">
                                <p>Available</p>
                                <h4 id="printing-pending">{{ $items->where('status', 'available')->count() }}</h4>
                            </div>
                            <div class="units-right">
                                <i class="fa-solid fa-thumbs-up"></i>
                            </div>
                        </div>
                    </div>
                    <div class="inv-card issued-units">
                        <div class="card-units">
                            <div class="units-left">
                                <p>Issued</p>
                                <h4 id="printing-pending">{{ $items->where('status', 'issued')->count() }}</h4>
                            </div>
                            <div class="units-right">
                                <i class="fa-solid fa-user-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="inv-card unusable-units">
                        <div class="card-units">
                            <div class="units-left">
                                <p>Unusable</p>
                                <h4 id="printing-pending">{{ $items->where('status', 'unusable')->count() }}</h4>
                            </div>
                            <div class="units-right">
                                <i class="fa-solid fa-ban"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="process-log">
                    <table class="process-table">
                        <thead>
                            <tr class="table-header">
                                <th>Unique ID</th>
                                <th>S/N</th>
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
                                    <td>{{ $item->serial_number ?? '—' }}</td>
                                    <td>
                                        @if ($item->status === 'available')
                                            <span class="inv-badge inv-status-available">Available</span>
                                        @elseif($item->status === 'issued')
                                            <span class="inv-badge inv-status-issued">Issued</span>
                                        @elseif($item->status === 'unusable')
                                            <span class="inv-badge inv-status-unusable">Unusable</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->condition === 'new')
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
                                        <button type="button" class="view-btn" data-bs-toggle="modal"
                                            data-bs-target="#viewModal{{ $item->id }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <form action="{{ route('destroy', $item) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-btn confirm-delete">
                                                <i class="fa-solid fa-trash"></i>
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

                            @include('modals.addUnit')
                        </tbody>
                    </table>
                </div>
                <div class="custom-pagination">
                    {{ $items->appends(request()->input())->links('pagination::bootstrap-5') }}
                </div>
            </main>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Preview Individual IDs
        document.getElementById('addQuantity').addEventListener('input', function() {
            const deviceId = '{{ $deviceId }}';
            const quantity = parseInt(this.value) || 1;
            const previewDiv = document.getElementById('addUnitPreview');

            // Get exisitng number of units
            const existingIds = @json($allIds);

            let previewText = '';
            const maxPreview = 5;

            const usedIds = [...existingIds];
            let newIds = [];

            // First, fill gaps
            let current = 1;
            while (newIds.length < quantity) {
                if (!usedIds.includes(current)) {
                    newIds.push(current);
                    usedIds.push(current);
                }
                current++;
            }

            // Show preview (max 5)
            for (let i = 0; i < Math.min(newIds.length, maxPreview); i++) {
                const individualId = `${deviceId}(${String(newIds[i]).padStart(2, '0')})`;
                previewText += `<span class="badge bg-secondary me-1 mb-1">${individualId}</span>`;
            }

            if (newIds.length > maxPreview) {
                previewText += `<span class="text-muted">... and ${newIds.length - maxPreview} more</span>`;
            }

            previewDiv.innerHTML = previewText;
        });

        // Show/hide assignment section based on status
        document.getElementById('addStatus').addEventListener('change', function() {
            const assignmentSection = document.getElementById('addAssignmentSection');
            assignmentSection.style.display = this.value === 'issued' ? 'block' : 'none';
        });

        // Initialize preview on modal open
        document.getElementById('addUnitModal').addEventListener('shown.bs.modal', function() {
            document.getElementById('addQuantity').dispatchEvent(new Event('input'));
        });
    </script>
@endpush
