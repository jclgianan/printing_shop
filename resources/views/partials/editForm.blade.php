<div id="editMode{{ $items->inventory_id }}">
    <form action="{{ route('inventory.update', $items->inventory_id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- If the item is already issued, we lock the status/condition to prevent data mismatch --}}
        @if ($items->status === 'issued')
            <input type="hidden" name="status" value="issued">
            <input type="hidden" name="condition" value="{{ $items->condition }}">
        @endif

        <div class="modal-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-info-square me-2"></i>Device Information</h6>
                <span class="badge bg-secondary">ID: {{ $items->inventory_id }}</span>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <label for="editSerialNumber{{ $items->inventory_id }}" class="form-label">Serial Number</label>
                    <input type="text" class="form-control" id="editSerialNumber{{ $items->inventory_id }}"
                        name="serial_number" value="{{ $items->serial_number }}" placeholder="e.g., SN1234567890">
                </div>
            </div>

            @if ($items->category === 'Computer System' || $items->category === 'Components')
                <h6 class="fw-bold mb-3"><i class="bi bi-cpu me-2"></i>Specifications</h6>
                <div class="row mb-3 g-3">
                    <div class="col-md-6">
                        <label class="form-label">Processor</label>
                        <input type="text" class="form-control" name="processor" value="{{ $items->processor }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">RAM</label>
                        <input type="text" class="form-control" name="ram" value="{{ $items->ram }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Storage</label>
                        <input type="text" class="form-control" name="storage" value="{{ $items->storage }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Graphics Card</label>
                        <input type="text" class="form-control" name="graphics_card"
                            value="{{ $items->graphics_card }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Other Specs</label>
                        <textarea class="form-control" name="other_specs" rows="2">{{ $items->other_specs }}</textarea>
                    </div>
                </div>
            @endif

            @if ($items->status !== 'issued')
                <hr>
                <h6 class="fw-bold mb-3"><i class="bi bi-gear me-2"></i>Status & Condition</h6>
                <div class="row mb-3 g-3">
                    <div class="col-md-6">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" name="status" required>
                            <option value="available" {{ $items->status === 'available' ? 'selected' : '' }}>Available
                            </option>
                            <option value="unusable" {{ $items->status === 'unusable' ? 'selected' : '' }}>Unusable
                            </option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Condition <span class="text-danger">*</span></label>
                        <select class="form-select" name="condition" required>
                            <option value="new" {{ $items->condition === 'new' ? 'selected' : '' }}>New</option>
                            <option value="good" {{ $items->condition === 'good' ? 'selected' : '' }}>Good</option>
                            <option value="fair" {{ $items->condition === 'fair' ? 'selected' : '' }}>Fair</option>
                            <option value="poor" {{ $items->condition === 'poor' ? 'selected' : '' }}>Poor</option>
                        </select>
                    </div>
                </div>
            @endif

            @if ($items->status === 'issued')
                <hr>
                <h6 class="fw-bold mb-3"><i class="bi bi-person-badge me-2"></i>Current Assignment</h6>
                <div class="row mb-3 g-3">
                    <div class="col-md-6">
                        <label class="form-label">Issued To</label>
                        <input type="text" class="form-control" name="issued_to" value="{{ $items->issued_to }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Office/Location</label>
                        <input type="text" class="form-control" name="office" value="{{ $items->office }}">
                    </div>
                </div>
            @endif

            <hr>
            <h6 class="fw-bold mb-3"><i class="bi bi-calendar3 me-2"></i>Important Dates</h6>
            <div class="row mb-3 g-3">
                <div class="col-md-4">
                    <label class="form-label">Date Acquired</label>
                    <input type="date" class="form-control" name="date_acquired"
                        value="{{ optional($items->date_acquired)->format('Y-m-d') }}">
                </div>
                @if ($items->status === 'issued')
                    <div class="col-md-4">
                        <label class="form-label">Date Issued</label>
                        <input type="date" class="form-control" name="date_issued"
                            value="{{ optional($items->date_issued)->format('Y-m-d') }}">
                    </div>
                @endif
            </div>

            <hr>
            <h6 class="fw-bold mb-3"><i class="bi bi-sticky me-2"></i>Notes</h6>
            <textarea class="form-control" name="notes" rows="3">{{ $items->notes }}</textarea>
        </div>

        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary" onclick="toggleEditMode('{{ $items->inventory_id }}')">
                <i class="bi bi-x-circle"></i> Cancel
            </button>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Save Changes
            </button>
        </div>
    </form>
</div>
