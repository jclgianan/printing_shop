<!-- Details Modal -->
<div class="modal fade" id="viewModal{{ $items->inventory_id }}" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $items->inventory_id }}</h5>
                <button id="closeModal{{ $items->inventory_id }}" type="button" class="btn-close"
                    data-bs-dismiss="modal"></button>
            </div>

            <!-- View Mode -->
            <div id="viewMode{{ $items->inventory_id }}">
                <div class="modal-body">
                    <div class="info-box">
                        <div class="row">
                            <h6 class="mb-3">Device Details</h6>
                            <div class="col-md-6 mb-3">
                                <strong>Device Name:</strong>
                                {{ $items->device_name }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Category:</strong>
                                {{ $items->category }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>Serial Number:</strong>
                                {{ $items->serial_number ?? 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <!-- Specifications (Conditional) -->
                    @if ($items->processor || $items->ram || $items->storage || $items->graphics_card)
                        <div class="info-box">

                            <h6 class="mb-3">Specifications</h6>
                            <div class="row">
                                @if ($items->processor)
                                    <div class="col-md-6 mb-2">
                                        <strong>Processor:</strong> {{ $items->processor }}
                                    </div>
                                @endif
                                @if ($items->ram)
                                    <div class="col-md-6 mb-2">
                                        <strong>RAM:</strong> {{ $items->ram }}
                                    </div>
                                @endif
                                @if ($items->storage)
                                    <div class="col-md-6 mb-2">
                                        <strong>Storage:</strong> {{ $items->storage }}
                                    </div>
                                @endif
                                @if ($items->graphics_card)
                                    <div class="col-md-6 mb-2">
                                        <strong>Graphics Card:</strong> {{ $items->graphics_card }}
                                    </div>
                                @endif
                            </div>
                            @if ($items->other_specs)
                                <div class="mt-2">
                                    <strong>Other Specs:</strong>
                                    {{ $items->other_specs }}
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="info-box">
                        <h6 class="mb-3">Status Information</h6>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>Status:</strong>
                                <span
                                    class="badge bg-{{ $items->status === 'available' ? 'success' : ($items->status === 'issued' ? 'primary' : 'danger') }}">
                                    {{ ucfirst($items->status) }}
                                </span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Condition:</strong>
                                <span
                                    class="badge bg-{{ $items->condition === 'new' ? 'info' : ($items->condition === 'good' ? 'success' : 'warning') }}">
                                    {{ ucfirst($items->condition) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if ($items->status === 'issued')
                        <div class="info-box">

                            <h6 class="mb-3">Assignment Information</h6>
                            <div class="row">
                                @if (!empty($items->issued_to))
                                    <div class="col-md-6 mb-2">
                                        <strong>Issued To:</strong> {{ $items->issued_to }}
                                    </div>
                                @endif

                                @if (!empty($items->office))
                                    <div class="col-md-6 mb-2">
                                        <strong>Office:</strong> {{ $items->office }}
                                    </div>
                                @endif
                            </div>
                        </div>

                    @endif

                    @if (!empty($items->date_acquired) || !empty($items->date_issued) || !empty($items->date_returned))
                        <div class="info-box">

                            <h6 class="mb-3">Dates</h6>
                            <div class="row">
                                @if ($items->date_acquired)
                                    <div class="col-md-6 mb-2">
                                        <strong>Date Acquired:</strong>
                                        {{ $items->date_acquired->format('M d, Y') }}
                                    </div>
                                @endif
                                @if ($items->date_issued)
                                    <div class="col-md-6 mb-2">
                                        <strong>Date Issued:</strong>
                                        {{ $items->date_issued->format('M d, Y') }}
                                    </div>
                                @endif
                                @if ($items->status !== 'issued' && $items->date_returned)
                                    <div class="col-md-4 mb-2">
                                        <strong>Date returned:</strong>
                                        {{ $items->date_returned->format('M d, Y') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                    @endif
                    @if ($items->notes)
                        <div class="info-box">

                            <h6 class="mb-2">Notes</h6>
                            <p class="mb-0">{{ $items->notes }}</p>
                        </div>
                    @endif

                    @if ($items->repairTickets && $items->repairTickets->isNotEmpty())
                        <div class="info-box">
                            <h6 class="mb-2">History</h6>
                            <ul class="mb-0" style="padding-left: 1rem;">
                                @foreach ($items->repairTickets as $ticket)
                                    <li>{{ \Carbon\Carbon::parse($ticket->receiving_date)->format('M d, Y') }} -
                                        {{ $ticket->issue }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    @if ($items->status === 'available')
                        <button type="button" class="btn btn-normal"
                            onclick="toggleIssue('{{ $items->inventory_id }}')">
                            Issue
                        </button>
                    @endif

                    @if ($items->status === 'issued')
                        <button type="button" class="btn btn-normal"
                            onclick="toggleReturn('{{ $items->inventory_id }}')">
                            Return
                        </button>
                    @endif

                    <button type="button" class="btn btn-normal"
                        onclick="toggleEditMode('{{ $items->inventory_id }}')">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                </div>
            </div>
            <div id="editMode{{ $items->inventory_id }}" style="display: none;">
                <div class="modal-body">
                    @include('partials.editForm')
                </div>
            </div>

            <div id="issueModal{{ $items->inventory_id }}" style="display: none;">
                <div class="modal-body">
                    @include('partials.issueForm')
                </div>
            </div>

            <div id="returnModal{{ $items->inventory_id }}" style="display: none;">
                <div class="modal-body">
                    @include('partials.returnForm')
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Helper function to switch between View and other forms
    function toggleMode(id, targetMode) {
        const viewMode = document.getElementById('viewMode' + id);
        const targetElement = document.getElementById(targetMode + id);
        const closeBtn = document.getElementById('closeModal' + id);

        console.log('Toggling ID:', id, 'Target:', targetMode); // Debug Log

        if (!viewMode || !targetElement) {
            console.error('Elements not found! View:', !!viewMode, 'Target:', !!targetElement);
            return;
        }

        const showingView = viewMode.style.display !== 'none';

        if (showingView) {
            // HIDE VIEW, SHOW FORM
            viewMode.setAttribute('style', 'display: none !important');
            targetElement.setAttribute('style', 'display: block !important');
            if (closeBtn) closeBtn.style.visibility = 'hidden';
        } else {
            // SHOW VIEW, HIDE FORM
            viewMode.setAttribute('style', 'display: block !important');
            targetElement.setAttribute('style', 'display: none !important');
            if (closeBtn) closeBtn.style.visibility = 'visible';
        }
    }

    function toggleEditMode(id) {
        toggleMode(id, 'editMode');
    }

    function toggleIssue(id) {
        toggleMode(id, 'issueModal');
    }

    function toggleReturn(id) {
        toggleMode(id, 'returnModal');
    }

    /* ========= FORM LOGIC (Status Change Handling) ========= */
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[id^="editStatus"]').forEach(statusSelect => {
            const id = statusSelect.id.replace('editStatus', '');
            const conditionSelect = document.getElementById('editCondition' + id);
            const assignmentSection = document.getElementById('editAssignmentSection' + id);
            const dateIssuedField = document.getElementById('editDateIssuedField' + id);

            statusSelect.addEventListener('change', function() {
                // Auto-set condition to poor if unusable
                if (this.value === 'unusable' && conditionSelect) {
                    conditionSelect.value = 'poor';
                }

                // Show/Hide assignment fields based on status
                const isIssued = this.value === 'issued';
                if (assignmentSection) assignmentSection.style.display = isIssued ? 'block' :
                    'none';
                if (dateIssuedField) dateIssuedField.style.display = isIssued ? 'block' :
                    'none';
            });
        });
    });
</script>
